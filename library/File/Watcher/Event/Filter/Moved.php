<?php

namespace File\Watcher\Event\Filter;

class Moved extends AbstractFilter
{
    public function accept()
    {
        $event = $this->current();

        if ($event->cookie > 0) {
            return true;
        }

        return false;
    }

}