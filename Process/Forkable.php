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
        
        $this->validateArguments($input);
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
        $mandatoryArguments = $this->getMandatoryArgumentMap();
        $options = $input->getOption('params');
        $options = $this->parseOptions($options);
        
        foreach ($mandatoryArguments as $mandatoryArgument) {
            if (!isset($options[$mandatoryArgument])) {
                throw new \InvalidArgumentException("$mandatoryArgument is rquired on params options");
            }
        }
        
        $this->params = $options;
    }
    
    protected function parseOptions($options)
    {
        $parsed = array();

        foreach ($options as $option) {
            $keyValues = explode('=', $option);

            for ($i=0; $i < count($keyValues)-1; $i+=2) {
                $value = $keyValues[$i+1];
                $explodedValue = explode(',', $value);
                $parsed[$keyValues[$i]] = count($explodedValue) > 1 ? $explodedValue : $explodedValue[0];
            }
        }
        
        return $parsed;
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
