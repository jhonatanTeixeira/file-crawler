<?php

namespace Daemon;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use FileSystem\Watcher\Event;

class FileWatcher extends \Process\Daemon
{
    private $inotify;
    
    public function __construct(InputInterface $input, EventDispatcher $eventDispatcher)
    {
        parent::__construct($input, $eventDispatcher);
        
        $this->inotify = new \FileSystem\Watcher\Inotify();
        
        $folders = (array) $this->getParam('folders', array());
        
        foreach ($folders as $folder) {
            $this->inotify->addFolder(
                new \FileSystem\Entity($folder)
            );
        }
    }
    
    protected function getMandatoryArgumentMap()
    {
        return array('folders');
    }

    protected function execute()
    {
        $events = $this->inotify->readEvents();
        
        $this->getEventDispatcher()->dispatch('file.created', new Event($events->getCreated()));
        $this->getEventDispatcher()->dispatch('file.modified', new Event($events->getModified()));
        $this->getEventDispatcher()->dispatch('file.moved', new Event($events->getMoved()));
        $this->getEventDispatcher()->dispatch('file.removed', new Event($events->getRemoved()));
    }
}