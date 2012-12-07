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

    /**
     * @param \FileSystem\Entity $file
     */
    public function addFile(\FileSystem\Entity $file)
    {
        $this->adapter->addFile($file);
    }

    /**
     * @param \FileSystem\Entity $file
     * @return \Indexer\FileSystem\Collection
     */
    public function getDirectoryFiles(\FileSystem\Entity $file)
    {
        return new File\Collection($this->adapter->getDirectoryFiles($file));
    }

    public function removeFile(\FileSystem\Entity $file)
    {
        $this->adapter->removeFile($file);
    }

    /**
     * @param string $filename
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

    public function optmize()
    {
        $this->adapter->optimize();
    }

    /**
     * @param string $term
     * @return \Indexer\FileSystem\Collection
     */
    public function search($term)
    {
        return new File\Collection($this->adapter->search($term));
    }
}
