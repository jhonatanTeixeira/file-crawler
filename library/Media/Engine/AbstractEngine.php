<?php

namespace Media\Engine;

abstract class AbstractEngine
{
    public static function factory(\File\Info $origin, \File\Info $target)
    {
        $originMime = $this->origin->getMime();
        
        $originExt = array_pop(explode('/', $originMime));
        $targetExt = $this->target->getExtension();
        
    }
}
