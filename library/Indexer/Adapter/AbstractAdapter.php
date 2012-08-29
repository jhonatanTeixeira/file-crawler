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
    
    abstract public function addFile(\File\Info $file);
    
    abstract public function removeFile(\File\Info $file);
    
    abstract public function searchFile($filename);
    
    abstract public function getDirectoryFiles(\File\Info $file);
}
