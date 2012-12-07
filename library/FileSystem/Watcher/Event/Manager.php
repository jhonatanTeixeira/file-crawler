<?php

namespace FileSystem\Watcher\Event;

class Manager extends \Pool\Manager
{
    /**
     * @param \FileSystem\Entity $file
     * @param string $actionName
     */
    public function add(\FileSystem\Entity $file, $actionName)
    {
        $row = new \Pool\Row();
        $row->setName($actionName);
        $row->setArgs(
            array(
                'file' => $file->getPathname()
            )
        );

        parent::add($row);
    }
}
