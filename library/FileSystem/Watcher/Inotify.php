<?php

namespace FileSystem\Watcher;

class Inotify
{
    private $resource;

    private $descriptors;

    public function __construct()
    {
        $this->resource = inotify_init();
        $this->descriptors = new Descriptor\Collection();
    }

    public function addFolder(\FileSystem\Entity $file)
    {
        if (!$this->isWatching($file) && $file->isDir()) {
            $descriptor = inotify_add_watch($this->resource, $file, IN_ALL_EVENTS);
            $this->descriptors[$descriptor] = new Descriptor\Item($this, $descriptor, $file);
        }

        return $this;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function isWatching(\FileSystem\Entity $file)
    {
        return (bool) $this->getDescriptors()->searchByFile($file)->count();
    }

    public function getDescriptorByFile(\FileSystem\Entity $file)
    {
        $descriptors = $this->getDescriptors()->searchByFile($file);
        $descriptors->rewind();

        return $descriptors->current();
    }

    public function getDescriptorByName($name)
    {
        return $this->getDescriptors()->offsetGet($name);
    }

    /**
     * @return Descriptor\Collection
     */
    public function getDescriptors()
    {
        return $this->descriptors;
    }

    /**
     * @return \FileSystem\Watcher\Event\Reader
     */
    public function readEvents()
    {
        return new Event\Reader($this);
    }
}