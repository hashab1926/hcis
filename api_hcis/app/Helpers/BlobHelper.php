<?php

namespace App\Helpers;

class BlobHelper
{
    public static function fileToBlob($file)
    {
        $getContent = file_get_contents($file->getPathName());
        $encoding = base64_encode($getContent);
        return $encoding;
    }
}
