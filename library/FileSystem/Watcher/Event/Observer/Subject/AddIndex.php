<?php

namespace FileSystem\Watcher\Event\Observer\Subject;

class AddIndex implements SubjectInterface
{
    /**
     * @var \FileSystem\Watcher\Event\Filter\AbstractFilter
     */
    private $events;

    public function execute()
    {
        $manager = new \FileSystem\Watcher\Event\Manager();

        /* @var $event \FileSystem\Watcher\Event\Item */
        foreach ($this->events as $event) {
            $manager->add(
                $event->getFile(),
                'indexFile'
            );
        }
    }

    public function setEvents(\FileSystem\Watcher\Event\Filter\AbstractFilter $collection)
    {
        $this->events = $collection;
    }
}