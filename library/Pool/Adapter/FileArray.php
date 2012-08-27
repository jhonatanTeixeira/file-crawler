<?php

namespace Pool\Adapter;

class FileArray extends AbstractAdapter
{
    private $config;

    private $rowSet;

    public function __construct()
    {
        $this->config = new \Zend_Config_Ini(APP_PATH . "/Config/config.ini", 'production');
    }

    public function add(array $row)
    {
        $content = $this->fetch();
        $last = end($content);
        $row['id'] = $last['id'] + 1;
        $content[] = $row;
        $this->save($content);

        return $this;
    }

    public function save(array $content)
    {
        file_put_contents($this->config->pool->adapter->file, serialize($content));

        return $this;
    }

    public function delete($id)
    {
        $index = $this->getIndexById($id);

        if ($index === false) {
            throw new \InvalidArgumentException("$id doesnt exists on the data");
        }

        $content = $this->fetch();
        unset($content[$index]);
        $this->save($content);

        return $this;
    }

    private function getIndexById($id)
    {
        $content = $this->fetch();

        foreach ($content as $key => $row) {
            if ($row['id'] == $id) {
                return $key;
            }
        }

        return false;
    }

    public function fetch()
    {
        if (!isset($this->rowSet)) {
            if (!file_exists($this->config->pool->adapter->file)) {
                return array();
            }

            $content = unserialize(@file_get_contents($this->config->pool->adapter->file));

            if ($content === false || !is_array($content)) {
                $this->rowSet = array();
            } else {
                $this->rowSet = $content;
            }
        }

        return $this->rowSet;
    }
}