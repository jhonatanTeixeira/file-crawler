<?php

namespace Daemon;

class FileWatcher extends AbstractDaemon
{
    private $inotify;

    private $indexer;

    public function __construct()
    {
        $this->inotify = new \FileSystem\Watcher\Inotify();
        $this->indexer = new \Indexer\Manager();

        $directories = new \FileSystem\Directory\Scanner(
            new \FileSystem\Entity(\Config\Ini::getInstance()->watcher->directory)
        );
        $directories->addCommand(new \FileSystem\Command\AddInotify($this->inotify))
            ->executeCommands();

        $media = new \FileSystem\Media\Scanner(
            new \FileSystem\Entity(\Config\Ini::getInstance()->watcher->directory)
        );
        $media->addFilter(new \FileSystem\Filter\NotIndexed())
            ->addCommand(new \FileSystem\Command\AddIndex())
            ->addCommand(new \FileSystem\Command\MakePreview())
            ->executeCommands();
    }

    protected function execute()
    {
        $manager = new \FileSystem\Watcher\Event\Observer\Manager($this->inotify->readEvents());
        $manager->addObserver(
            new \FileSystem\Watcher\Event\Observer\Subject\AddIndex(),
            new \Enum\EventType(\Enum\EventType::CREATED)
        )->addObserver(
            new \FileSystem\Watcher\Event\Observer\Subject\MakePreview(),
            new \Enum\EventType(\Enum\EventType::CREATED)
        );

        $manager->notify();
    }
}