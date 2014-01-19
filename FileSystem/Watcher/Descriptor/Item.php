<?php

namespace FileSystem\Watcher\Descriptor;

class Item
{
    private $resource;

    private $file;

    private $descriptor;

    public function __construct(\FileSystem\Watcher\Inotify $inotify, $descriptor, \FileSystem\Entity $file)
    {
        $this->setResource($inotify);
        $this->setDescriptor($descriptor);
        $this->setFile($file);
    }

    public function setResource(\FileSystem\Watcher\Inotify $inotify)
    {
        $this->resource = $inotify->getResource();
    }

    public function setFile(\FileSystem\Entity $file)
    {
        $this->file = $file;
    }

    public function setDescriptor($descriptor)
    {
        $this->descriptor = $descriptor;
    }

    /**
     * @return \FileSystem\Entity
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getDescriptor()
    {
        return $this->descriptor;
    }
}