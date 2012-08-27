<?php

namespace File\Watcher\Event\Observer;

class Manager
{
    private $subjects;

    private $events;

    public function __construct(\File\Watcher\Event\Reader $reader)
    {
        $this->subjects = new \SplObjectStorage();
        $this->setEvents($reader);
    }

    public function setEvents(\File\Watcher\Event\Reader $events)
    {
        $this->events = $events;
    }

    public function addObserver(Subject\SubjectInterface $subject, \Enum\EventType $type)
    {
        switch ($type->getValue()) {
            case \Enum\EventType::CREATED:
                $subject->setEvents($this->events->getCreated());
                break;
            case \Enum\EventType::MODIFIED:
                $subject->setEvents($this->events->getModified());
                break;
            case \Enum\EventType::MOVED:
                $subject->setEvents($this->events->getMoved());
                break;
            case \Enum\EventType::REMOVED:
                $subject->setEvents($this->events->getRemoved());
                break;
        }

        $this->subjects->attach($subject);
    }

    public function notify()
    {
        foreach ($this->subjects as $subject) {
            $subject->execute();
        }
    }
}