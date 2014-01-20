<?php

namespace FileSystem\Watcher\Event;

class Collection extends \FilterIterator
{
    private $inotify;

    public function __construct($inotify)
    {
        if ($inotify instanceof \FileSystem\Watcher\Inotify) {
            $content = inotify_read($inotify->getResource());

            if ($content !== false) {
                parent::__construct(new \ArrayIterator($content));
            } else {
                parent::__construct(new \ArrayIterator());
            }
    
            $this->inotify = $inotify;
        } elseif ($inotify instanceof Collection) {
            parent::__construct($inotify);
            $this->inotify = $inotify->getInotify();
        }
    }

    public function current()
    {
        $current = parent::current();
        
        if ($current instanceof Item) {
            return $current;
        }
        
        return new Item($current, $this->inotify);
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