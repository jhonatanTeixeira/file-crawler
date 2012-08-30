<?php

namespace Indexer\Adapter;

class ZendSearch extends AbstractAdapter
{
    private $search;

    private $config;

    public function __construct()
    {
        $this->config = \Config\Ini::getInstance();

        try {
            $this->search = \Zend_Search_Lucene::open($this->config->indexer->directory);
        } catch (\Zend_Search_Lucene_Exception $exception) {
            $this->search = \Zend_Search_Lucene::create($this->config->indexer->directory);
            syslog(LOG_INFO, $exception->getMessage());
        }
    }

    public function addFile(\File\Info $file)
    {
        if (count($this->searchFile($file->getPathname())) > 0) {
            syslog(LOG_INFO, "file {$file->getPathname()} already indexed");
            return;
        }

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
    }

    public function getDirectoryFiles(\File\Info $file)
    {
        $pathName = $file->isDir() ? $file->getPathname() : $file->getPath();

        return $this->search->find("directory:\"$pathName\"");
    }

    public function removeFile(\File\Info $file)
    {

    }

    /**
     * @param string $filename
     * @return \Zend_Search_Lucene_Search_QueryHit
     */
    public function searchFile($filename)
    {
        $hash = md5($filename);
        $files = $this->search->find("md5:$hash");

        return array_shift($files);
    }

    public function optimize()
    {
        $this->search->optimize();
    }

    public function search($term)
    {
        return $this->search->find($term);
    }

}
