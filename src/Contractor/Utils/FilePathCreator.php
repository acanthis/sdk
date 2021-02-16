<?php

namespace Eds\Contractor\Utils;

use Eds\Common\Utils\FileHashGenerator;
use Eds\Contractor\Abstraction\ConfigInterface;

class FilePathCreator
{
    private ConfigInterface $config;
    private FileHashGenerator $fileHashGenerator;

    public function __construct(ConfigInterface $config, FileHashGenerator $fileHashGenerator)
    {
        $this->config = $config;
        $this->fileHashGenerator = $fileHashGenerator;
    }

    public function cretePackageDocFilePath(string $filePath, string $fileExtension, string $contractorId, string $packageDocId): string
    {
        $ownerId = '33ddde8a-58aa-3552-961c-3c0862a38e11'; //TODO заменить на клиентский ID

        return sprintf(
            $this->config->getPackageDoc()->getFilePathPattern(),
            $ownerId,
            $contractorId,
            $packageDocId,
            $this->fileHashGenerator->generate($filePath),
            $fileExtension
        );
    }
}
