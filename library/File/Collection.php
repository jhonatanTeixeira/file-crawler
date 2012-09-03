<?php

namespace File;

class Collection extends \FilterIterator
{
    private $filters = array();

    public function __construct(\RecursiveDirectoryIterator $directoryIterator)
    {
        $directoryIterator->setFlags(
            \RecursiveDirectoryIterator::CURRENT_AS_SELF | \RecursiveDirectoryIterator::SKIP_DOTS
        );
        $iterator = new \RecursiveIteratorIterator($directoryIterator, \RecursiveIteratorIterator::CHILD_FIRST);

        parent::__construct($iterator);
    }

    public function addFilter(Filter\FilterInterface $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * @return \File\Info
     */
    public function current()
    {
        return parent::current()->getFileInfo("\\File\\Info");
    }

    public function accept()
    {
        foreach ($this->filters as $filter) {
            if (!$filter->accept($this->current())) {
                return false;
            }
        }

        return true;
    }
}