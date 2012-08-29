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

    public function add(array $row)
    {
        if (!isset($row['priority'])) {
            $row['priority'] = 0;
        }

        $this->adapter->add($row);
    }

    public function delete($id)
    {
        $this->adapter->delete($id);
    }

    public function fetch()
    {
        return $this->adapter->fetch();
    }
}