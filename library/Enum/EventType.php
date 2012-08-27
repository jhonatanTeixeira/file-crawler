<?php

namespace Enum;

class EventType extends AbstractEnum
{
    const MOVED     = 1;
    const REMOVED   = 2;
    const MODIFIED  = 3;
    const CREATED   = 4;
}