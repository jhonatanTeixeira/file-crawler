<?php

namespace Enum;

abstract class AbstractEnum
{
    protected $selectedEnum;

    protected $reflection;

    public function __construct($value = null)
    {
        $this->reflection = new \ReflectionObject($this);
        $enumList = $this->reflection->getConstants();

        if ($value === null) {
            if (!array_key_exists('_DEFAULT', $enumList)) {
                throw new \UnexpectedValueException('no default constant set for this enum');
            }

            $value = $enumList['_DEFAULT'];
        }

        if (!in_array($value, $enumList)) {
            throw new \UnexpectedValueException('value does exists for this enum');
        }

        $this->selectedEnum = array_search($value, $enumList);
    }

    public function getValue()
    {
        return $this->reflection->getConstant($this->selectedEnum);
    }

    public function __toString()
    {
        return (string) $this->getValue();
    }
}