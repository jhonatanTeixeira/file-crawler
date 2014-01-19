<?php

namespace Process;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

abstract class Forkable
{
    private $pid;
    
    private $inputInterface;
    
    private $eventDispatcher;
    
    private $params = array();
    
    public function __construct(InputInterface $input, EventDispatcher $eventDispatcher)
    {
        $this->inputInterface   = $input;
        $this->eventDispatcher  = $eventDispatcher;
    }
        
    public function getPid()
    {
        return $this->pid;
    }

    public function setPid($pid)
    {
        $this->pid = $pid;
    }
    
    protected function getMandatoryArgumentMap()
    {
        return array();
    }
    
    protected function validateArguments(InputInterface $input)
    {
        $mandatoryArguments = $this->getArgumentMap();
        $options = json_decode($input->getOption('params'), true);
        
        if (false === $options) {
            throw new \InvalidArgumentException("{$input->getOption('params')} is not a valid json");
        }
        
        foreach ($mandatoryArguments as $mandatoryArgument) {
            if (!isset($options[$mandatoryArgument])) {
                throw new \InvalidArgumentException("$mandatoryArgument is rquired on params json");
            }
        }
        
        $this->params = $options;
    }
    
    public function getParam($name, $default = null)
    {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        }
        
        return $default;
    }
    
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }
        
    public abstract function run();
}
