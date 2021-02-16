<?php

namespace Eds\Common\Utils;

use RuntimeException;

class FileHashGenerator
{
    public function generate(string $filePath): string
    {
        if (!$fileHash = md5_file($filePath)) {
            throw new RuntimeException(sprintf('Error on get file hash'), $filePath);
        }

        return $fileHash;
    }
}
