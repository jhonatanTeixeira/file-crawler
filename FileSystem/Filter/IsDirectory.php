<?php

namespace FileSystem\Filter;

class IsDirectory implements FilterInterface
{
    public function accept(\FileSystem\Entity $file)
    {
        return $file->isDir();
    }
}