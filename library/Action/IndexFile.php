<?php

namespace Action;

class IndexFile extends AbstractAction
{
    public function execute()
    {
        $manager = new \Indexer\Manager();
        $file = new \File\Info($this->getParams('file'));
        $manager->addFile($file);
    }
}