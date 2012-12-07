<?php

namespace Pool;

class Collection implements \Iterator
{
    private $data;

    public function __construct()
    {
        $this->data = new \SplObjectStorage();
    }

    public function current()
    {
        return $this->data->current();
    }

    public function key()
    {
        return $this->data->key();
    }

    public function next()
    {
        $this->data->next();
    }

    public function rewind()
    {
        $this->data->rewind();
    }

    public function valid()
    {
        return $this->data->valid();
    }

    public function append(Row $row)
    {
        if ($this->data->contains($row) === false) {
            $this->data->attach($row);
        }

        return $this;
    }

    public function remove(Row $row)
    {
        if ($this->data->contains($row)) {
            $this->data->detach($row);
        }

        return $this;
    }
}