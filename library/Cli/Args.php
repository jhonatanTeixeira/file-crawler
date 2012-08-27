<?php

namespace Cli;

class Args
{
    private $args = array();

    public function __construct()
    {
        global $argv;
        $this->args = $argv;
    }

    public function get($argName, $default = null)
    {
        $argName = "--$argName";

        $index = array_search($argName, $this->args);

        if ($index === false) {
            return $default;
        }

        return $this->args[$index+1];
    }

    public function toArray()
    {
        $indexes = array();
        foreach ($this->args as $key => $arg) {
            if (preg_match("/^--/", $arg)) {
                $indexes[] = $key;
            }
        }

        $values = array();
        foreach ($indexes as $index) {
            $values[str_replace("--", "", $this->args[$index])] = $this->args[$index+1];
        }

        return $values;
    }
}