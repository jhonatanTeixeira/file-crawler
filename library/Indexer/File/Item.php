<?php

namespace Indexer\File;

class Item
{
    private $id;
    
    private $score;
    
    private $md5;
    
    private $type;
    
    private $filename;
    
    private $directory;
    
    private $previewPath;
    
    public function __construct($item)
    {
        $this->id          = $item->id;
        $this->score       = $item->score;
        $this->directory   = $item->directory;
        $this->filename    = $item->filename;
        $this->md5         = $item->md5;
        $this->type        = $item->type;
        $this->previewPath = $item->previewPath;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getScore()
    {
        return $this->score;
    }
        
    public function getMd5()
    {
        return $this->md5;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getDirectory()
    {
        return $this->directory;
    }

    public function getPreviewPath()
    {
        return $this->previewPath;
    }
}
