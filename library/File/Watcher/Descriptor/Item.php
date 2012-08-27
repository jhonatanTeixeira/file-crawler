<?php

namespace File\Watcher\Descriptor;

class Item
{
    private $resource;

    private $file;

    private $descriptor;

    public function __construct(\File\Watcher\Inotify $inotify, $descriptor, \File\Info $file)
    {
        $this->setResource($inotify);
        $this->setDescriptor($descriptor);
        $this->setFile($file);
    }

    public function setResource(\File\Watcher\Inotify $inotify)
    {
        $this->resource = $inotify->getResource();
    }

    public function setFile(\File\Info $file)
    {
        $this->file = $file;
    }

    public function setDescriptor($descriptor)
    {
        $this->descriptor = $descriptor;
    }

    /**
     * @return \File\Info
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