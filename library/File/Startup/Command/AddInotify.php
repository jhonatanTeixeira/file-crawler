<?php

namespace File\Startup\Command;

class AddInotify extends AbstractCommand
{
    private $inotify;

    public function __construct(\File\Watcher\Inotify $inotify)
    {
        $this->inotify = $inotify;
    }

    public function execute(\File\Info $file)
    {
        if ($file->isDir()) {
            $this->inotify->addFolder($file);
            syslog(LOG_INFO, "watching folder $file");
        }
    }
}