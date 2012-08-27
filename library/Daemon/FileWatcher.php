<?php

namespace Daemon;

class FileWatcher extends AbstractDaemon
{
    private $inotify;

    public function __construct()
    {
        $this->inotify = new \File\Watcher\Inotify();
        $directoryIterator = new \RecursiveDirectoryIterator(
            '/home/developer/teste crawler',
            \RecursiveDirectoryIterator::CURRENT_AS_SELF | \RecursiveDirectoryIterator::SKIP_DOTS
        );

        foreach (new \RecursiveIteratorIterator($directoryIterator, \RecursiveIteratorIterator::CHILD_FIRST) as $file) {
            if ($file->isDir()) {
                echo $file . " will be watched \n";
                $this->inotify->addFolder($file->getFileInfo("\\File\\Info"));
            }
        }
    }

    protected function excute()
    {
        $manager = new \File\Watcher\Event\Observer\Manager($this->inotify->readEvents());
        $manager->addObserver(
            new \File\Watcher\Event\Observer\Subject\DisplayName(),
            new \Enum\EventType(\Enum\EventType::CREATED)
        );
        $manager->notify();
    }
}