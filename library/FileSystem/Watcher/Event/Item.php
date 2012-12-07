<?php

namespace FileSystem\Watcher\Event;

class Item extends \ArrayObject
{
    private $inotify;

    public function __construct(array $event, \FileSystem\Watcher\Inotify $inotify)
    {
        parent::__construct($event, \ArrayObject::ARRAY_AS_PROPS);
        $this->setInotify($inotify);
    }

    public function setInotify(\FileSystem\Watcher\Inotify $inotify)
    {
        $this->inotify = $inotify;
    }

    /**
     * @return \FileSystem\Entity
     */
    public function getFile()
    {
        $descriptor = $this->getDescriptor()->getFile();
        $filename = "{$descriptor->getPathname()}/{$this->offsetGet('name')}";

        return new \FileSystem\Entity($filename);
    }

    /**
     * @return \FileSystem\Watcher\Descriptor\Item
     */
    public function getDescriptor()
    {
        return $this->inotify->getDescriptorByName($this->offsetGet('wd'));
    }
}