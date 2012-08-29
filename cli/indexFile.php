<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once '../bootstrap.php';

$args = new \Cli\Args();

$manager = new Indexer\Manager();
$file = new File\Info($args->get('file'));
//$manager->addFile($file);

var_dump($manager->getDirectoryFiles($file));

$search = Zend_Search_Lucene::open('/tmp/indexer');

$results = $search->find('filename:"imag10"');

foreach ($results as $result) {
    var_dump($result->filename, $result->directory);
}