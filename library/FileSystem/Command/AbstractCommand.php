<?php

namespace FileSystem\Command;

abstract class AbstractCommand
{
    abstract public function execute(\FileSystem\Entity $file);
}