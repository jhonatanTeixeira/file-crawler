<?php

namespace FileSystem\Watcher\Event;

class Reader
{
    private $events;

    public function __construct(\FileSystem\Watcher\Inotify $inotify)
    {
        $this->events = new Collection($inotify);
    }

    public function getMoved()
    {
        return new Filter\Moved($this->events);
    }

    public function getRemoved()
    {
        return new Filter\Removed($this->events);
    }

    public function getModified()
    {
        return new Filter\Modified($this->events);
    }

    public function getCreated()
    {
        return new Filter\Created($this->events);
    }
}