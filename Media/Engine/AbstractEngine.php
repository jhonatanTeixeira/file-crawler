<?php

namespace Media\Engine;

abstract class AbstractEngine
{
    private static $config;

    /**
     * @var \FileSystem\Entity
     */
    private $origin;

    /**
     * @var \FileSystem\Entity
     */
    private $target;

    public static function factory(\Enum\MediaOperation $opreration, \FileSystem\Entity $origin, \FileSystem\Entity $target = null)
    {
        if ($target !== null) {
            $targetExt = $target->getExtension();
        }

        $originMime = $origin->getMime();

        $originExt = array_pop(explode('/', $originMime));

        switch ($opreration->getValue()) {
            case \Enum\MediaOperation::CONVERT:
                $className = "\\Media\\Engine\\"
                           . self::getConfig()->get('converter')->get($originExt)->get($targetExt);
                break;
            case \Enum\MediaOperation::RESIZE:
                $className = "\\Media\\Engine\\" . self::getConfig()->get('resizer')->get($originExt);
                break;
        }

        $class = new $className();

        if (!$class instanceof self) {
            throw new \InvalidArgumentException(get_class($class) . 'is not an abstract engine');
        }

        $class->setOrigin($origin);

        if ($target !== null) {
            $class->setTarget($target);
        }

        return $class;
    }

    /**
     * @return \Config\Ini
     */
    public static function getConfig()
    {
        if (!isset(self::$config)) {
            self::$config = new \Config\Ini(__DIR__ . "/../../App/Config/config.ini", 'media');
        }

        return self::$config;
    }

    public function setTarget(\FileSystem\Entity $target)
    {
        $this->target = $target;
    }

    public function setOrigin(\FileSystem\Entity $origin)
    {
        $this->origin = $origin;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function getOrigin()
    {
        return $this->origin;
    }

    abstract public function resize($width, $height);

    abstract public function convert();
}
