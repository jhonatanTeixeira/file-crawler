<?php

require_once '../bootstrap.php';

ini_set('display_errors', true);
error_reporting(E_ALL);

$args = new \Cli\Args();

$manager = new Indexer\Manager();

$file = new File\Info($args->get('file'));
//$manager->addFile($file);

//var_dump($manager->getDirectoryFiles($file));

var_dump($manager->searchFile($file->getPathname())->getFilename());