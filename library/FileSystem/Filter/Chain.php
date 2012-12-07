<?php

namespace FileSystem\Filter;

class Chain extends \FilterIterator
{
    private $filters = array();

    public function __construct(\FileSystem\Collection $collection)
    {
        parent::__construct($collection);
    }

    /**
     * @param \FileSystem\Filter\FilterInterface $filter
     * @return \FileSystem\Filter\Chain
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;

        return $this;
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