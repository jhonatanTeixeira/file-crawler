<?php

namespace FileSystem\Command;

class MakePreview extends AbstractCommand
{
    public function execute(\FileSystem\Entity $file)
    {
        $manager = new \FileSystem\Watcher\Event\Manager();

        $manager->add(
            $file,
            'makePreview'
        );
    }
}