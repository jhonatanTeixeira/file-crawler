<?php

namespace FileSystem\Watcher\Event\Filter;

abstract class AbstractFilter extends \FileSystem\Watcher\Event\Collection implements \Countable
{
    /**
     * @var \FileSystem\Watcher\Event\Collection
     */
    private $eventCollection;

    public function __construct(\FileSystem\Watcher\Event\Collection $eventCollection)
    {
        $this->eventCollection = $eventCollection;
    }
    
    public function getInotify()
    {
        return $this->eventCollection->getInotify();
    }
    
    public function current()
    {
        return $this->eventCollection->current();
    }

    public function count()
    {
        return count(iterator_to_array($this));
    }
}