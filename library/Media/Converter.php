<?php

namespace Media;

class Converter
{
    private $origin;
    
    private $target;
    
    public function __construct(\File\Info $origin, \File\Info $target)
    {
        $this->setOrigin($origin);
        $this->setTarget($target);
    }
    
    public function setOrigin(\File\Info $origin)
    {
        $this->origin = $origin;
        
        return $this;
    }

    public function setTarget(\File\Info $target)
    {
        $this->target = $target;
        
        return $this;
    }
    
    public function convert()
    {
        
    }
}
