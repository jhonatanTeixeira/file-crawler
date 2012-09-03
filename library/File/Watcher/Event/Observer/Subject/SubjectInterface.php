<?php

namespace File\Watcher\Event\Observer\Subject;

interface SubjectInterface
{
    function setEvents(\File\Watcher\Event\Filter\AbstractFilter $collection);

    function execute();
}