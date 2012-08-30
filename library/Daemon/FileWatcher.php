<?php

namespace Daemon;

class FileWatcher extends AbstractDaemon
{
    private $inotify;

    private $indexer;

    public function __construct()
    {
        $this->inotify = new \File\Watcher\Inotify();
        $this->indexer = new \Indexer\Manager();

        $directoryIterator = new \RecursiveDirectoryIterator(
            \Config\Ini::getInstance()->watcher->directory,
            \RecursiveDirectoryIterator::CURRENT_AS_SELF | \RecursiveDirectoryIterator::SKIP_DOTS
        );

        foreach (new \RecursiveIteratorIterator($directoryIterator, \RecursiveIteratorIterator::CHILD_FIRST) as $file) {
            $info = $file->getFileInfo("\\File\\Info");

            if ($file->isDir()) {
                syslog(LOG_INFO, "$file will be watched");
                $this->inotify->addFolder($info);
            } else {
                syslog(LOG_INFO, "$file indexed");
                $this->indexer->addFile($info);
            }
        }
    }

    protected function excute()
    {
        $manager = new \File\Watcher\Event\Observer\Manager($this->inotify->readEvents());
        $manager->addObserver(
            new \File\Watcher\Event\Observer\Subject\AddIndex(),
            new \Enum\EventType(\Enum\EventType::CREATED)
        );
        $manager->notify();
    }
}