<?php

namespace Daemon;

class HelloWorld extends \Process\Daemon
{
    protected function execute()
    {
        echo "Hello World\n";
    }
}
