<?php

namespace File\Filter;

class IsMedia implements FilterInterface
{
    public function accept(\File\Info $file)
    {
        return $file->isFile() && ($file->isImage() || $file->isVideo());
    }
}