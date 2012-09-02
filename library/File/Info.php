<?php

namespace File;

class Info extends \SplFileInfo
{
    public function getNameMd5()
    {
        return md5($this->getPathname());
    }
    
    public function getMime()
    {
        $mime = new \Media\MimeType();
        
        return $mime->getMime($this);
    }
    
    public function getExtension()
    {
        if (method_exists(parent, 'getExtension')) {
            return parent::getExtension();
        }
        
        return pathinfo($this->getPathname(), PATHINFO_EXTENSION);
    }
}