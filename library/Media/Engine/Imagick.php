<?php

namespace Media\Engine;

class Imagick extends AbstractEngine
{
    private $imagick;
    
    public function __construct()
    {
        $this->imagick = new \Imagick($this->getOrigin()->getPathname());
    }
    
    public function convert()
    {
        $this->imagick->writeimage($this->getTarget()->getPathname());
    }

    public function resize($width, $height)
    {
        $this->imagick->adaptiveresizeimage($width, $height, true);
        $this->imagick->writeimage($this->getTarget()->getPathname());
    }
}
