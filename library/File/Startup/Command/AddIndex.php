<?php

namespace File\Startup\Command;

class AddIndex extends AbstractCommand
{
    public function execute(\File\Info $file)
    {
        $manager = new \File\Watcher\Event\Manager();

        $manager->add(
            $file,
            'indexFile'
        );
    }
}