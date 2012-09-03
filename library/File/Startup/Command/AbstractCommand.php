<?php

namespace File\Startup\Command;

abstract class AbstractCommand
{
    private $file;

    public function __construct(\File\Collection $file)
    {
        $this->file = $file;
    }

    /**
     * @return \File\Info
     */
    public function getFile()
    {
        return $this->file;
    }

    abstract public function execute();
}