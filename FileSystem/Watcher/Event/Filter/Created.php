<?php

namespace FileSystem\Watcher\Event\Filter;

class Created extends AbstractFilter
{
    public function accept()
    {
        $event = $this->current();

        if (($event->mask == IN_CREATE or $event->getFile()->isDir())
            and !$this->getInotify()->isWatching($event->getFile())) {
            return true;
        }

        return false;
    }

}