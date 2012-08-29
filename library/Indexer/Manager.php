<?php

namespace Indexer;

class Manager
{
    private $adapter;

    private $config;

    public function __construct()
    {
        $this->config  = \Config\Ini::getInstance();
        $this->adapter = Adapter\AbstractAdapter::factory($this->config->indexer->adapter->name);
    }

    public function addFile(\File\Info $file)
    {
        $this->adapter->addFile($file);
    }

    public function getDirectoryFiles(\File\Info $file)
    {
        return $this->adapter->getDirectoryFiles($file);
    }

    public function removeFile(\File\Info $file)
    {
        $this->adapter->removeFile($file);
    }

    public function searchFile($filename)
    {
        return $this->adapter->searchFile($filename);
    }
}
