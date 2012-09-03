<?php

namespace File\Startup;

class Chain
{
    private $commands = array();

    private $collection;

    public function __construct(\File\Collection $collection)
    {
        $this->collection = $collection;
    }

    public function addCommand(Command\AbstractCommand $command)
    {
        $this->commands[] = $command;
    }

    public function execute()
    {
        /* @var $command \File\Watcher\Event\Observer\Subject\SubjectInterface */
        foreach ($this->commands as $command) {
            
        }
    }
}