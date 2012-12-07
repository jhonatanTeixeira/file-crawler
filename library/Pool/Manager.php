<?php

namespace Pool;

class Manager
{
    private $adapter;

    private $config;

    public function __construct()
    {
        $this->config  = \Config\Ini::getInstance();
        $this->adapter = Adapter\AbstractAdapter::factory($this->config->pool->adapter->name);
    }

    public function add(Row $row)
    {
        if ($row->hasPriority()) {
            $row->setPriority(0);
        }

        $this->adapter->add($row);
        $this->adapter->save();
    }

    public function delete(Row $row)
    {
        $this->adapter->delete($row);
        $this->adapter->save();
    }

    public function fetch()
    {
        return $this->adapter->fetch();
    }
}