<?php

namespace FileSystem\Directory;

class Scanner extends \FileSystem\Scanner
{

    protected function addDefaultFilters()
    {
        $this->addFilter(new \FileSystem\Filter\IsDirectory());
    }

    protected function getInfoClassName()
    {
        return "\\FileSystem\\Entity";
    }
}