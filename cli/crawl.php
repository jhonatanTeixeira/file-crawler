#!/usr/bin/php
<?php
require_once '../bootstrap.php';

$forker = new Proccess\Forker();
$forker->addDaemon(new \Daemon\FileWatcher());
$forker->addDaemon(new \Daemon\Pool());
$forker->startDaemons();
