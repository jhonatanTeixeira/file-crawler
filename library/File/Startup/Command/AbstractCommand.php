<?php

namespace File\Startup\Command;

abstract class AbstractCommand
{
    abstract public function execute(\File\Info $file);
}