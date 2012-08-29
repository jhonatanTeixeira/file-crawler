<?php

namespace Indexer\File;

class Collection extends \ArrayIterator
{
    public function current()
    {
        return new Item(parent::current());
    }
}
