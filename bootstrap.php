<?php

define('APP_PATH', __DIR__ . '/library/App');

set_include_path(
    implode(
        PATH_SEPARATOR,
        array(
            get_include_path(),
            realpath(__DIR__ . "/library")
        )
    )
);

spl_autoload_register(
    function ($class)
    {
        $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
        $class = str_replace("_", DIRECTORY_SEPARATOR, $class);

        @include_once "$class.php";
    }
);