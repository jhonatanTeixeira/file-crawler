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

    /**
     * @param \File\Info $file
     * @return \Indexer\File\Collection
     */
    public function getDirectoryFiles(\File\Info $file)
    {
        return new File\Collection($this->adapter->getDirectoryFiles($file));
    }

    public function removeFile(\File\Info $file)
    {
        $this->adapter->removeFile($file);
    }

    /**
     * @param type $filename
     * @return File\Item
     */
    public function searchFile($filename)
    {
        $item = $this->adapter->searchFile($filename);
        
        if (empty($item)) {
            return false;
        }
        
        return new File\Item($item);
    }
}
