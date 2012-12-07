<?php

namespace Daemon;

class Pool extends AbstractDaemon
{
    private $children = array();

    private $maxChildren = 10;

    private $isChild = false;

    /**
     * @var \SplPriorityQueue
     */
    private $queue;

    private $manager;

    public function __construct()
    {
        pcntl_signal(SIGCHLD, array($this, 'childEnd'));
        $this->startQueue();
    }

    public function start()
    {
        while (!\Proccess\Forker::isDying() && !$this->isChild) {
            if (!$this->queue->valid() || $this->queue->isEmpty()) {
                $this->startQueue();
                continue;
            }

            if (count($this->children) == $this->maxChildren) {
                continue;
            }

            $this->execute();
            $this->queue->next();
        }
    }

    public function childEnd($signal)
    {
        foreach ($this->children as $key => $pid) {
            pcntl_waitpid($pid, $status, WNOHANG | WUNTRACED);

            if ($pid > 0) {
                unset($this->children[$key]);
                syslog(LOG_INFO, "child finished with status $status, remaining " . count($this->children));
            }
        }
    }

    protected function execute()
    {
        $actionRow = $this->queue->current();
        $this->fork($actionRow);
        $this->manager->delete($actionRow);
    }

    private function fork($actionRow)
    {
        $pid = pcntl_fork();

        switch ($pid) {
            case -1:
                syslog(LOG_ERR, "failed to fork an action");
                break;
            case 0:
                $this->isChild = true;
                $action = \Action\AbstractAction::factory($actionRow->getName(), $actionRow->getArgs());

                try {
                    $action->setPid(getmypid());
                    $action->invoke();
                } catch (Exception $exception) {
                    syslog(LOG_ERR, $exception->getMessage());
                }

                exit;
            default:
                pcntl_wait($status, WNOHANG | WUNTRACED);
                $this->children[] = $pid;
        }
    }

    private function startQueue()
    {
        $this->manager = new \Pool\Manager();

        $requests = $this->manager->fetch();

        $this->queue = new \SplPriorityQueue();

        /* @var $request \Pool\Collection */
        foreach ($requests as $request) {
            $this->queue->insert($request, $request->getPriority());
        }

        $this->queue->rewind();
    }
}