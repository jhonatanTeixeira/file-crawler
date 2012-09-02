<?php

namespace File\Watcher\Event\Observer\Subject;

class AddIndex implements SubjectInterface
{
    /**
     * @var \File\Watcher\Event\Filter\AbstractFilter
     */
    private $events;

    public function execute()
    {
        $manager = new \File\Watcher\Event\Manager();

        /* @var $event \File\Watcher\Event\Item */
        foreach ($this->events as $event) {
            $manager->add(
                $event->getFile(),
                'indexFile'
            );
        }
    }

    public function setEvents(\File\Watcher\Event\Filter\AbstractFilter $collection)
    {
        $this->events = $collection;
    }
}