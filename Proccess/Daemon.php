<?php

namespace Procees;

abstract class Daemon extends Forkable
{
    public function run()
    {
        $pid = getmypid();

        if ($pid != $this->pid) {
            return;
        }

        while (!\Proccess\Forker::isDying()) {

            try {
                $this->execute();
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

    abstract protected function execute();
}