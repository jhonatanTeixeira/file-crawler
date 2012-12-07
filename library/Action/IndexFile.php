<?php

namespace Action;

class IndexFile extends AbstractAction
{
    public function execute()
    {
        $manager = new \Indexer\Manager();
        $file = new \FileSystem\Entity($this->getParams('file'));
        $manager->addFile($file);
    }
}