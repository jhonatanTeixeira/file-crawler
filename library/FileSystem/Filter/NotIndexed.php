<?php

namespace FileSystem\Filter;

class NotIndexed implements FilterInterface
{
    private $manager;

    public function __construct()
    {
        $this->manager = new \Indexer\Manager();
    }

    public function accept(\FileSystem\Entity $file)
    {
        return $this->manager->searchFile($file->getPathname()) === false;
    }
}