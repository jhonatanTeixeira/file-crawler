<?php

namespace Media;

class MimeType
{
    public static function getMime(\File\Info $file)
    {
        $pathName = $file->getPathname();
        exec("minetype $pathName", $result);
        $mime = trim(array_pop(explode(":", $result)));

        return $mime;
    }
}