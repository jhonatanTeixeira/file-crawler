<?php

namespace File\Watcher\Event;

class Item extends \ArrayObject
{

    private $inotify;

    public function __construct(array $event, \File\Watcher\Inotify $inotify)
    {
        parent::__construct($event, \ArrayObject::ARRAY_AS_PROPS);
        $this->setInotify($inotify);
    }

    public function setInotify(\File\Watcher\Inotify $inotify)
    {
        $this->inotify = $inotify;
    }

    /**
     * @return \File\Info
     */
    public function getFile()
    {
        $descriptor = $this->getDescriptor()->getFile();
        $filename = "{$descriptor->getPathname()}/{$this->offsetGet('name')}";

        return new \File\Info($filename);
    }

    /**
     * @return \File\Watcher\Descriptor\Item
     */
    public function getDescriptor()
    {
        return $this->inotify->getDescriptorByName($this->offsetGet('wd'));
    }
}