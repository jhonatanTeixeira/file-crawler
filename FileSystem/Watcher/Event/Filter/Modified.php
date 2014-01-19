<?php

namespace FileSystem\Watcher\Event\Filter;

class Modified extends AbstractFilter
{
    public function accept()
    {
        $event = $this->current();

        if ($event->mask == IN_MODIFY
            or $event->mask == IN_CLOSE_WRITE) {
            return true;
        }

        return false;
    }

}