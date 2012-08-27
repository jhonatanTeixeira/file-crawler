<?php

namespace File\Watcher\Descriptor;

class Collection extends \ArrayIterator
{
    public function searchByFile(\File\Info $file)
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

    public function append(\File\Watcher\Descriptor $value)
    {
        parent::append($value);
    }
}