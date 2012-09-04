<?php

namespace Proccess;

class Forker
{
    private $daemons = array();

    private $isDaemon = false;

    private static $isDying = false;

    public function __construct()
    {
        declare(ticks = 1);

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

    public function addDaemon(\Daemon\AbstractDaemon $daemon)
    {
        $this->daemons[] = $daemon;
    }

    public function startDaemons()
    {
        foreach ($this->daemons as $daemon) {

            if ($this->isDaemon) {
                continue;
            }

            $pid = pcntl_fork();

            switch ($pid) {
                case -1:
                    syslog(LOG_ERR, "failed to fork a daemon");
                    break;
                case 0:
                    $this->isDaemon = true;
                    $daemon->setPid(getmypid());
                    $daemon->start();
                    break;
                default:
                    pcntl_wait($status, WNOHANG | WUNTRACED);
                    break;
            }
        }

        if (!$this->isDaemon) {
            exit;
        }
    }

    public static function isDying()
    {
        return self::$isDying;
    }
}