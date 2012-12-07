<?php

namespace Pool\Adapter;

class FileArray extends AbstractAdapter
{
    private $config;

    private $data;

    public function __construct()
    {
        $this->config = \Config\Ini::getInstance();
        $this->data = new \Pool\Collection();
    }

    public function add(\Pool\Row $row)
    {
        $this->data->append($row);

        return $this;
    }

    public function delete(\Pool\Row $row)
    {
        $this->data->remove($row);

        return $this;
    }

    public function save()
    {
        file_put_contents($this->config->pool->adapter->file, serialize($this->data));

        return $this;
    }

    /**
     * @return \Pool\Collection
     */
    public function fetch()
    {
        if (!file_exists($this->config->pool->adapter->file)) {
            return $this->data;
        }

        $content = unserialize(@file_get_contents($this->config->pool->adapter->file));

        if ($content === false || !$content instanceof \Pool\Collection) {
            return $this->data;
        }

        $this->data = $content;

        return $this->data;
    }
}