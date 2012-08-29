<?php

namespace Indexer\Adapter;

class ZendSearch extends AbstractAdapter
{
    private $search;
    private $config;

    public function __construct()
    {
        $this->config  = \Config\Ini::getInstance();

        try {
            $this->search = \Zend_Search_Lucene::open($this->config->indexer->directory);
        } catch (Zend_Search_Lucene_Exception $exception) {
            $this->search = \Zend_Search_Lucene::create($this->config->indexer->directory);
            syslog(LOG_INFO, $exception->getMessage());
        }
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
        $this->search->commit();
        echo $this->search->count();
    }

    public function getDirectoryFiles(\File\Info $file)
    {
        $pathName = $file->isDir() ? $file->getPathname() : $file->getPath();
        $term = new \Zend_Search_Lucene_Index_Term($pathName, 'directory');
        $query = new \Zend_Search_Lucene_Search_Query_Term($term);

        return new \Indexer\File\Collection($this->search->find($query));
    }

    public function removeFile(\File\Info $file)
    {

    }

    /**
     * @param string $filename
     * @return \Indexer\File\Item
     */
    public function searchFile($filename)
    {
        $term = new \Zend_Search_Lucene_Index_Term($filename, 'filename');
        $query = new \Zend_Search_Lucene_Search_Query_Term($term);

        $files = new \Indexer\File\Collection($this->search->find($query));
        $files->rewind();

        return $files->current();
    }

}
