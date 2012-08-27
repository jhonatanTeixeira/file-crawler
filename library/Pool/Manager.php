<?php

namespace Pool;

class Manager
{
    private $adapter;

    private $config;

    public function __construct()
    {
        $this->config  = new \Zend_Config_Ini(APP_PATH . "/Config/config.ini", 'production');
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