#!/usr/bin/php
<?php

require_once '../bootstrap.php';

$manager = new \Pool\Manager();

$args = new \Cli\Args();

$values = $args->toArray();
$row = array('name' => $values['name']);
unset($values['name']);
$row['args'] = $values;

$manager->add($row);