<?php

namespace Process;

abstract class Forkable
{
    private $pid;
    
    public function getPid()
    {
        return $this->pid;
    }

    public function setPid($pid)
    {
        $this->pid = $pid;
    }
        
    public abstract function run();
}
