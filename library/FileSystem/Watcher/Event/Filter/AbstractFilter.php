<?php

namespace FileSystem\Watcher\Event\Filter;

abstract class AbstractFilter extends \FilterIterator implements \Countable
{
    private $inotify;

    public function __construct(\FileSystem\Watcher\Event\Collection $iterator)
    {
        parent::__construct($iterator);
        $this->setInotify($iterator->getInotify());
    }

    public function setInotify(\FileSystem\Watcher\Inotify $inotify)
    {
        $this->inotify = $inotify;
    }

    /**
     * @return \FileSystem\Watcher\Inotify
     */
    public function getInotify()
    {
        return $this->inotify;
    }

    public function count()
    {
        return count(iterator_to_array($this));
    }
}