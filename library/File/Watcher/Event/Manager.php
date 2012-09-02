<?php

namespace File\Watcher\Event;

class Manager extends \Pool\Manager
{
    /**
     * @param \File\Info $file
     * @param string $actionName
     */
    public function add(\File\Info $file, $actionName)
    {
        $row = array(
            'name' => $actionName,
            'args' => array(
                'file' => $file->getPathname()
            )
        );
        
        parent::add($row);
    }
}
