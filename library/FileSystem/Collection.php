<?php

namespace FileSystem;

class Collection implements \Iterator
{
    private $files = array();

    public function key()
    {
        return key($this->files);
    }

    public function next()
    {
        next($this->files);
    }

    public function rewind()
    {
        reset($this->files);
    }

    public function valid()
    {
        return $this->key() !== null;
    }

    public function append(Entity $file)
    {
        $this->files[] = $file;
    }

    public function current()
    {
        return current($this->files);
    }
}