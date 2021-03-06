<?php

namespace Media\Engine;

class Imagick extends AbstractEngine
{
    private $imagick;

    public function __construct()
    {
        $this->imagick = new \Imagick();
    }

    public function setOrigin(\FileSystem\Entity $origin)
    {
        parent::setOrigin($origin);
        $this->imagick->readimage($origin->getPathname());
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
