<?php

namespace File\Watcher\Event\Observer\Subject;

class AddIndex implements SubjectInterface
{
    private $events;

    public function execute()
    {
        $manager = new \Pool\Manager();

        foreach ($this->events as $event) {
            $manager->add(
                array(
                    'name' => 'IndexFile',
                    'args' => array(
                        'file' => $event->getFile()->getPathname()
                    )
                )
            );
        }
    }

    public function setEvents(\File\Watcher\Event\Filter\AbstractFilter $collection)
    {
        $this->events = $collection;
    }
}