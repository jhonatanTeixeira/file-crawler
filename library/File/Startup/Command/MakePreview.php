<?php

namespace File\Startup\Command;

class MakePreview extends AbstractCommand
{
    public function execute(\File\Info $file)
    {
        $manager = new \File\Watcher\Event\Manager();

        $manager->add(
            $file,
            'makePreview'
        );
    }
}