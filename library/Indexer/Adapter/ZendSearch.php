<?php

namespace Indexer\Adapter;

class ZendSearch extends AbstractAdapter
{
    private $search;
    private $config;
    
    public function __construct()
    {
        $this->config  = new \Zend_Config_Ini(APP_PATH . "/Config/config.ini", 'production');
        $this->search = new \Zend_Search_Lucene($this->config->indexer->file);
    }
    
    public function addFile(\File\Info $file)
    {
        $document = new \Zend_Search_Lucene_Document();
        $document->addField(\Zend_Search_Lucene_Field::keyword('md5', $file->getNameMd5()));
        $document->addField(\Zend_Search_Lucene_Field::keyword('type', $file->isDir() ? 'dir' : 'file'));
        $document->addField(\Zend_Search_Lucene_Field::text('filename', $file->getPathname()));
        $document->addField(\Zend_Search_Lucene_Field::text('directory', $file->getPath()));
        
        if (!$file->isDir()) {
            $document->addField(
                \Zend_Search_Lucene_Field::unIndexed(
                    'previewPath', 
                    "{$this->config->indexer->previewPath}/{$file->getNameMd5()}"
                )
            );
        }
        
        $this->search->addDocument($document);
    }

    public function getDirectoryFiles(\File\Info $file)
    {
        $term = new \Zend_Search_Lucene_Index_Term('direcotory', $file->getPathname());
        $query = new \Zend_Search_Lucene_Search_Query_Term($term);
        
        return $this->search->find($query);
    }

    public function removeFile(\File\Info $file)
    {
        
    }

    public function searchFile($filename)
    {
        $term = new \Zend_Search_Lucene_Index_Term('filename', $filename);
        $query = new \Zend_Search_Lucene_Search_Query_Term($term);
        
        return $this->search->find($query);
    }

}
