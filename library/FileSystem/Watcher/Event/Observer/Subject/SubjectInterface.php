<?php

namespace FileSystem\Watcher\Event\Observer\Subject;

interface SubjectInterface
{
    function setEvents(\FileSystem\Watcher\Event\Filter\AbstractFilter $collection);

    function execute();
}