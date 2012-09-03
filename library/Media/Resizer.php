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
            new \Enum\MediaOperation(\Enum\MediaOperation::RESIZE),
            $origin
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
        $target  = $this->engine->getConfig()->resizer->thumb->path;
        $target .= "/{$this->origin->getNameMd5()}.png";
        $this->engine->setTarget($target);

        $this->resize(
            $this->engine->getConfig()->resizer->thumb->width,
            $this->engine->getConfig()->resizer->thumb->height
        );
    }

    public function makePreview()
    {
        $target  = $this->engine->getConfig()->resizer->preview->path;
        $target .= "/{$this->origin->getNameMd5()}.png";
        $this->engine->setTarget($target);

        $this->resize(
            $this->engine->getConfig()->resizer->preview->width,
            $this->engine->getConfig()->resizer->preview->height
        );
    }

    public function resize($width, $height)
    {
        if ($this->engine->getTarget() === null) {
            $this->engine->setTarget($this->target);
        }

        $this->engine->resize($width, $height);
    }
}
