<?php

namespace Pool;

class Row
{
    private $id;

    private $name;

    private $args;

    private $priority;

    public function __construct(array $data = null)
    {
        if (null !== $data) {
            if (isset($data['id'])) {
                $this->setId($data['id']);
            }

            $this->setName($data['name']);
            $this->setArgs($data['args']);

            if (isset($data['priority'])) {
                $this->setPriority($data['priority']);
            }
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function getArgs()
    {
        return $this->args;
    }

    public function setArgs(array $args)
    {
        $this->args = $args;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority($priority)
    {
        $this->priority = (int) $priority;
    }

    public function hasPriority()
    {
        return isset($this->priority);
    }
}