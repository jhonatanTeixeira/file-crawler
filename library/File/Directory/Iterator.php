<?php

namespace File\Directory;

class Iterator extends \DirectoryIterator
{
    public function current()
    {
        return new \File\Info(parent::current()->getPathname());
    }
}