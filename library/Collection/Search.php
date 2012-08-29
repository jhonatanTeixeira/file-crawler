<?php

namespace Collection;

class Search extends \FilterIterator implements \Countable
{
    private $closure;

    public function __construct(Iterator $iterator, \Closure $closure)
    {
        parent::__construct($iterator);
        $this->closure = $closure;
    }

    public function accept()
    {
        return (bool) call_user_func($this->closure, $this->current());
    }

    public function count()
    {
        return count(iterator_to_array($this));
    }
}