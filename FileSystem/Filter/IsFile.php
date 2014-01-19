<?php

namespace FileSystem\Filter;

class IsFile implements FilterInterface
{
    public function accept(\FileSystem\Entity $file)
    {
        return $file->isFile();
    }
}