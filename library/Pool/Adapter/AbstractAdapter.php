<?php

namespace Pool\Adapter;

abstract class AbstractAdapter
{
    /**
     * @param string $adapterName
     * @return \Pool\Adapter\AbstractAdapter
     * @throws \InvalidArgumentException
     */
    public static function factory($adapterName)
    {
        $adapterName = "\\Pool\\Adapter\\" . ucfirst($adapterName);
        $adapter = new $adapterName();

        if (!$adapter instanceof AbstractAdapter) {
            throw new \InvalidArgumentException('adapter must be instance of abstract adapter');
        }

        return $adapter;
    }

    abstract public function fetch();

    abstract public function delete(\Pool\Row $row);

    abstract public function add(\Pool\Row $row);
}