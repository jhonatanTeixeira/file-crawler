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

    /**
     * @param \File\Startup\Command\AbstractCommand $command
     * @return \File\Startup\Chain
     */
    public function addCommand(Command\AbstractCommand $command)
    {
        $this->commands[] = $command;

        return $this;
    }

    /**
     * @return \File\Startup\Chain
     */
    public function execute()
    {
        foreach ($this->collection as $file) {
            /* @var $command \File\Startup\Command\AbstractCommand */
            foreach ($this->commands as $command) {
                $command->execute($file);
            }
        }

        return $this;
    }
}