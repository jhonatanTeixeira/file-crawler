<?php

namespace Indexer\File;

class Collection extends \ArrayIterator
{
    /**
     * @return \Indexer\FileSystem\Item
     */
    public function current()
    {
        return new Item(parent::current());
    }

    public function search(\Closure $closure)
    {
        return new Search($this, $closure);
    }
}
