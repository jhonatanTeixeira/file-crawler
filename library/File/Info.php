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

    public function isImage()
    {
        return (bool) preg_match('/^image/', $this->getMime());
    }

    public function isVideo()
    {
        return (bool) preg_match('/^video/', $this->getMime());
    }
}