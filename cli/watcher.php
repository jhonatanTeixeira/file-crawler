#!/usr/bin/php
<?php
require_once '../bootstrap.php';

ini_set('display_errors', true);
error_reporting(E_ALL);

$forker = new Proccess\Forker();
$forker->addDaemon(new \Daemon\FileWatcher());
$forker->startDaemons();