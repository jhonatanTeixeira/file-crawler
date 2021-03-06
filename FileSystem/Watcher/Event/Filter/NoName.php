<?php

namespace FileSystem\Watcher\Event\Filter;

class NoName extends \FilterIterator
{
    public function accept()
    {
        return isset($this->current()->name);
    }
}