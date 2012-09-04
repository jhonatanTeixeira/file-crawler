<?php

namespace Daemon;

abstract class AbstractDaemon
{
    private $pid;

    public function start()
    {
        $pid = getmypid();

        if ($pid != $this->pid) {
            return;
        }

        while (!\Proccess\Forker::isDying()) {

            try {
                $this->excute();
            } catch (Exception $exception) {
                syslog(LOG_ERR, $exception->getMessage());
            }

            $this->iterate(1);
        }

        $this->stop();
    }

    public function stop()
    {
        //override me
    }

    protected function iterate($seconds)
    {
        sleep($seconds);

        if (!gc_enabled()) {
            gc_enable();
        }

        gc_collect_cycles();
    }

    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    abstract protected function excute();
}