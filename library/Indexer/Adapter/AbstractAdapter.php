<?php

namespace Indexer\Adapter;

abstract class AbstractAdapter
{
    public static function factory($adapterName)
    {
        $adapterName = "\\Indexer\\Adapter\\" . ucfirst($adapterName);
        $adapter = new $adapterName();

        if (!$adapter instanceof AbstractAdapter) {
            throw new \InvalidArgumentException('adapter must be instance of abstract adapter');
        }

        return $adapter;
    }

    abstract public function addFile(\FileSystem\Entity $file);

    abstract public function removeFile(\FileSystem\Entity $file);

    abstract public function searchFile($filename);

    abstract public function search($term);

    abstract public function getDirectoryFiles(\FileSystem\Entity $file);

    abstract public function optimize();
}
