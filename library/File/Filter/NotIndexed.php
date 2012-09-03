<?php

namespace File\Filter;

class NotIndexed implements FilterInterface
{
    private $manager;

    public function __construct()
    {
        $this->manager = new \Indexer\Manager();
    }

    public function accept(\File\Info $file)
    {
        return $this->manager->searchFile($file->getPathname()) === false;
    }
}