<?php

set_include_path(
    implode(
        PATH_SEPARATOR,
        array(
            get_include_path(),
            realpath(__DIR__ . "/../")
        )
    )
);

/* @var $loader \Composer\Autoload\ClassLoader */
$loader = include '../vendor/autoload.php';
$loader->setUseIncludePath(true);

$stopWatch = new Symfony\Component\Stopwatch\Stopwatch();
$stopWatch->start('application');

$application = new \Symfony\Component\Console\Application();
$application->add(new \Command\HelloWorld());
$application->add(new \Command\StartProcess());
$application->setAutoExit(false);
$exitCode = $application->run();

$event = $stopWatch->stop('application');

printf(
    "\n------------------------------------------------------------------\n"
    ."This apllication has taken %s seconds to run and consumed %s mb memory \n",
    $event->getDuration() / 1000,
    $event->getMemory() / 1024 / 1024
);

exit($exitCode);