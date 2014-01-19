<?php

namespace Subscriber;

class NewFile implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'file.created' => array('onFileCreated')
        );
    }

    public function onFileCreated(\FileSystem\Watcher\Event $fileEvents)
    {
        foreach ($fileEvents->getFileEvents() as $fileEvent) {
            echo $fileEvent;
        }
    }
}
