<?php

namespace FileSystem\Watcher\Event;

class Collection extends \FilterIterator
{
    private $inotify;

    public function __construct(\FileSystem\Watcher\Inotify $inotify)
    {
        $content = inotify_read($inotify->getResource());

        if ($content !== false) {
            parent::__construct(new \ArrayIterator($content));
        } else {
            parent::__construct(new \ArrayIterator());
        }

        $this->inotify = $inotify;
    }

    public function current()
    {
        return new Item(parent::current(), $this->inotify);
    }

    public function getInotify()
    {
        return $this->inotify;
    }

    public function accept()
    {
        return true;
    }
}