<?php

namespace File\Watcher\Event;

class Collection extends \ArrayIterator
{
    private $inotify;

    public function __construct(\File\Watcher\Inotify $inotify)
    {
        $content = inotify_read($inotify->getResource());

        if ($content !== false) {
            parent::__construct($content);
        } else {
            parent::__construct();
        }

        $this->inotify = $inotify;
    }

    public function append($value)
    {
        throw new Exception("cannot append");
    }

    public function current()
    {
        return new Item(parent::current(), $this->inotify);
    }

    public function offsetGet($index)
    {
        return new Item(parent::offsetGet($index));
    }

    public function offsetSet($index, $newval)
    {
        throw new Exception("cannot append");
    }

    public function getInotify()
    {
        return $this->inotify;
    }
}