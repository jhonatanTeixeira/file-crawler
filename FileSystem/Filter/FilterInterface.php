<?php

namespace FileSystem\Filter;

interface FilterInterface
{
    function accept(\FileSystem\Entity $file);
}