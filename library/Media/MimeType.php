<?php

namespace Media;

class MimeType
{
    public static function getMime(\File\Info $file)
    {
        $pathName = $file->getPathname();
        exec("mimetype $pathName", $result);
        $mime = trim(array_pop(explode(":", end($result))));

        return $mime;
    }
}