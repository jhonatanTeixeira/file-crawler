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
            \Config\Ini::getInstance()->watcher->directory
        );

        $directories = new \File\Collection($directoryIterator);
        $directories->addFilter(new \File\Filter\IsDirectory());

        $files = new \File\Collection($directoryIterator);
        $files->addFilter(new \File\Filter\NotIndexed())
            ->addFilter(new \File\Filter\IsMedia());

        $directoriesChain = new \File\Startup\Chain($directories);
        $directoriesChain->addCommand(new \File\Startup\Command\AddInotify($this->inotify))
            ->execute();

        $filesChain = new \File\Startup\Chain($files);
        $filesChain->addCommand(new \File\Startup\Command\AddIndex())
            ->addCommand(new \File\Startup\Command\MakePreview())
            ->execute();
    }

    protected function excute()
    {
        $manager = new \File\Watcher\Event\Observer\Manager($this->inotify->readEvents());
        $manager->addObserver(
            new \File\Watcher\Event\Observer\Subject\AddIndex(),
            new \Enum\EventType(\Enum\EventType::CREATED)
        )->addObserver(
            new \File\Watcher\Event\Observer\Subject\MakePreview(),
            new \Enum\EventType(\Enum\EventType::CREATED)
        );
        
        $manager->notify();
    }
}