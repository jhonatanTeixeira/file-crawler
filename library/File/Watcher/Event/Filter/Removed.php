<?php

namespace File\Watcher\Event\Filter;

class Removed extends AbstractFilter
{
    public function accept()
    {
        $event = parent::current();

        if ($event->mask == IN_DELETE
            or $event->mask == IN_DELETE_SELF
            or !$event->getFile()->exists()) {
            return true;
        }

        return false;
    }

}