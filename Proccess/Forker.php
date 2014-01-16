<?php

namespace Proccess;

class Forker
{
    private $isFork = false;

    private static $isDying = false;

    public function __construct()
    {
        $signals = array(SIGALRM, SIGCHLD, SIGTERM, SIGHUP, SIGINT);

        foreach ($signals as $signal) {
            pcntl_signal($signal, array($this, 'signals'));
        }
    }

    public function signals($signal)
    {
        switch ($signal) {
            case SIGALRM:
            case SIGCHLD:
                pcntl_wait($status, WUNTRACED);
                break;
            case SIGTERM:
            case SIGHUP:
            case SIGINT:
                self::$isDying = true;
                syslog(LOG_INFO, "daemons stoped");
                exit;
                break;
        }
    }

    public function fork(\Process\Forkable $forkable)
    {
        if ($this->isFork) {
            return;
        }

        $pid = pcntl_fork();

        switch ($pid) {
            case -1:
                syslog(LOG_ERR, "failed to fork a daemon");
                break;
            case 0:
                $this->isFork = true;
                $forkable->setPid(getmypid());
                $forkable->run();
                break;
            default:
                pcntl_wait($status, WNOHANG | WUNTRACED);
                break;
        }

        if (!$this->isFork) {
            exit;
        }
    }

    public static function isDying()
    {
        return self::$isDying;
    }
}