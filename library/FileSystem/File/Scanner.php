<?php

namespace FileSystem\File;

class Scanner extends \FileSystem\Scanner
{

    protected function addDefaultFilters()
    {
        $this->addFilter(new \FileSystem\Filter\IsFile());
    }

    protected function getInfoClassName()
    {
        return "\\FileSystem\\Entity";
    }
}