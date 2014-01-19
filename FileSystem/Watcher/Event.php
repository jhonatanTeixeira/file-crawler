<?php

namespace FileSystem\Watcher;

class Event extends \Symfony\Component\EventDispatcher\Event
{
    /**
     * @var Event\Collection
     */
    private $fileEvents;

    public function __construct(Event\Collection $fileEvents)
    {
        $this->fileEvents = $fileEvents;
    }
    
    public function getFileEvents()
    {
        return $this->fileEvents;
    }
}
