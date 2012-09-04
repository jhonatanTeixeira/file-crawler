<?php

namespace Action;

abstract class AbstractAction
{
    private $params = array();

    private $pid;

    /**
     * @param string $actionName
     * @param array $params
     * @return \Action\AbstractAction
     * @throws \InvalidArgumentException
     */
    public static function factory($actionName, array $params)
    {
        $actionName = ucfirst($actionName);
        $class = "\\Action\\$actionName";
        $action = new $class();

        if (!$action instanceof AbstractAction) {
            throw new \InvalidArgumentException("$action must extend AbstractAction");
        }

        $action->setParams($params);

        return $action;
    }

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    public function getParams($index = null, $default = null)
    {
        if ($index !== null) {
            if (isset($this->params[$index])) {
                return $this->params[$index];
            }

            return $default;
        }

        return $this->params;
    }

    public function getPid()
    {
        return $this->pid;
    }

    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    public function invoke()
    {
        if (getmypid() != $this->pid) {
            return;
        }

        $this->execute();
    }

    abstract public function execute();
}