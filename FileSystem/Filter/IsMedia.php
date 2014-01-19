<?php

namespace FileSystem\Filter;

class IsMedia implements FilterInterface
{
    public function accept(\FileSystem\Entity $file)
    {
        return $file->isFile() && ($file->isImage() || $file->isVideo());
    }
}