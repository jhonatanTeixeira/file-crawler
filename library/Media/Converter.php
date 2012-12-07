<?php

namespace Media;

class Converter
{
    private $origin;
    
    private $target;
    
    public function __construct(\FileSystem\Entity $origin, \FileSystem\Entity $target)
    {
        $this->setOrigin($origin);
        $this->setTarget($target);
    }
    
    public function setOrigin(\FileSystem\Entity $origin)
    {
        $this->origin = $origin;
        
        return $this;
    }

    public function setTarget(\FileSystem\Entity $target)
    {
        $this->target = $target;
        
        return $this;
    }
    
    public function convert()
    {
        
    }
}
