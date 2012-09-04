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

    protected function excute()
    {
        if ($this->isChild) {
            return;
        }

        $this->startQueue();

        if ($this->queue->count() === 0) {
            return;
        }

        foreach ($this->queue as $actionRow) {
            if (!(count($this->children) < $this->maxChildren)) {
                return;
            }

            $this->fork($actionRow);

            if (!$this->isChild) {
                $this->manager->delete($actionRow->id);
            }
        }
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
                $action = \Action\AbstractAction::factory($actionRow->name, $actionRow->args);
                try {
                    $action->execute();
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

        foreach ($requests as $key => $request) {
            $this->queue->insert((object) $request, $request['priority']);
        }
    }
}