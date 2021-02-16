<?php

namespace Eds\Contractor\Dto\Config;

class PackageDocConfig
{
    private array $allowTypes = [];
    private int $maxFileSize;
    private string $filePathPattern;

    public function __construct(array $allowTypes, int $maxFileSize, string $filePathPattern)
    {
        $this->allowTypes = $allowTypes;
        $this->maxFileSize = $maxFileSize;
        $this->filePathPattern = $filePathPattern;
    }

    public function getAllowTypes(): array
    {
        return $this->allowTypes;
    }

    public function getMaxFileSize(): int
    {
        return $this->maxFileSize;
    }

    public function getFilePathPattern(): string
    {
        return $this->filePathPattern;
    }
}
