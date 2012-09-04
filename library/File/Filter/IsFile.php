<?php

namespace File\Filter;

class IsFile implements FilterInterface
{
    public function accept(\File\Info $file)
    {
        return $file->isFile();
    }
}