<?php

namespace File\Filter;

interface FilterInterface
{
    function accept(\File\Info $file);
}