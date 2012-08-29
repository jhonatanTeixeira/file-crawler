<?php

namespace File;

class Info extends \SplFileInfo
{
    public function getNameMd5()
    {
        return md5($this->getPathname());
    }
}