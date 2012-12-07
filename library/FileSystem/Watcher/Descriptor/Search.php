<?php

namespace FileSystem\Watcher\Descriptor;

class Search extends \Collection\Search
{
    public function __construct(Collection $iterator, \Closure $closure)
    {
        parent::__construct($iterator, $closure);
    }
}