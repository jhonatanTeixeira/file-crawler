<?php

namespace FileSystem\Command;

class Chain
{
    private $commands = array();

    private $collection;

    public function __construct(\FileSystem\Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @param \FileSystem\Command\AbstractCommand $command
     * @return \FileSystem\Command\Chain
     */
    public function addCommand(AbstractCommand $command)
    {
        $this->commands[] = $command;

        return $this;
    }

    /**
     * @return \FileSystem\Command\Chain
     */
    public function execute()
    {
        foreach ($this->collection as $file) {
            /* @var $command \FileSystem\Command\AbstractCommand */
            foreach ($this->commands as $command) {
                $command->execute($file);
            }
        }

        return $this;
    }
}