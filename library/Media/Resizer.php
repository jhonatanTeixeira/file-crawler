<?php

namespace Media;

class Resizer
{
    private $origin;
    
    private $target;
    
    /**
     * @var Engine\AbstractEngine 
     */
    private $engine;
    
    public function __construct(\File\Info $origin, \File\Info $target)
    {
        $this->setOrigin($origin);
        $this->setTarget($target);
        
        $this->engine = Engine\AbstractEngine::factory(
            $origin, 
            $target, 
            new \Enum\MediaOperation(\Enum\MediaOperation::RESIZE)
        );
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
    
    public function makeThumb()
    {
        $this->resize(
            $this->engine->getConfig()->resizer->thumb->width, 
            $this->engine->getConfig()->resizer->thumb->height
        );
    }
    
    public function makePreview()
    {
        $this->resize(
            $this->engine->getConfig()->resizer->thumb->width, 
            $this->engine->getConfig()->resizer->thumb->height
        );
    }
    
    public function resize($width, $height)
    {
        
    }
}
