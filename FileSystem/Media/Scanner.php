<?php

namespace FileSystem\Media;

class Scanner extends \FileSystem\Scanner
{
    protected function addDefaultFilters()
    {
        $this->addFilter(new \FileSystem\Filter\IsMedia());
    }

    protected function getInfoClassName()
    {
        return "\\FileSystem\\Entity";
    }
}