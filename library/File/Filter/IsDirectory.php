<?php

namespace File\Filter;

class IsDirectory implements FilterInterface
{
    public function accept(\File\Info $file)
    {
        return $file->isDir();
    }
}