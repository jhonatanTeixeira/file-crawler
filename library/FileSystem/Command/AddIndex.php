<?php

namespace FileSystem\Command;

class AddIndex extends AbstractCommand
{
    public function execute(\FileSystem\Entity $file)
    {
        $manager = new \FileSystem\Watcher\Event\Manager();

        $manager->add(
            $file,
            'indexFile'
        );
    }
}