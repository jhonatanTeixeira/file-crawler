<?php

namespace FileSystem\Watcher\Event\Observer\Subject;

class DisplayName implements SubjectInterface
{
    private $events;

    public function execute()
    {
        var_dump("files created");
        foreach ($this->events as $event) {
            var_dump($event->getFile()->getPathname());
            var_dump($event);
        }
    }

    public function setEvents(\FileSystem\Watcher\Event\Filter\AbstractFilter $collection)
    {
        $this->events = $collection;
    }
}