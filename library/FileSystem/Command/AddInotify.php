<?php

namespace FileSystem\Command;

class AddInotify extends AbstractCommand
{
    private $inotify;

    public function __construct(\FileSystem\Watcher\Inotify $inotify)
    {
        $this->inotify = $inotify;
    }

    public function execute(\FileSystem\Entity $file)
    {
        if ($file->isDir()) {
            $this->inotify->addFolder($file);
            syslog(LOG_INFO, "watching folder $file");
        }
    }
}