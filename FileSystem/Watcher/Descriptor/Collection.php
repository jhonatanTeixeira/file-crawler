<?php

namespace FileSystem\Watcher\Descriptor;

class Collection extends \ArrayIterator
{
    public function searchByFile(\FileSystem\Entity $file)
    {
        $search = new Search(
            $this,
            function (Item $descriptor) use ($file)
            {
                return $descriptor->getFile()->getPathname() == $file->getPathname();
            }
        );

        return $search;
    }

    public function append(\FileSystem\Watcher\Descriptor $value)
    {
        parent::append($value);
    }
}