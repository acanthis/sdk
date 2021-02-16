<?php

namespace Nrg\Files\Persistence\Abstraction;

use Nrg\Files\Entity\Directory;
use Nrg\Files\Entity\File;
use Nrg\Files\Value\Path;

interface FileRepositoryInterface
{
    public function createDirectory(Directory $directory): void;

    public function readDirectory(Path $path): Directory;

    public function deleteDirectory(Path $path): void;

    public function createFile(File $file): void;

    public function readFile(Path $path): File;

    public function updateFile(File $file): void;

    public function deleteFile(string $filePath): void;

    public function copyFile(Path $path, Path $newPath): void;

    public function moveFile(Path $path, Path $newPath): void;

    public function writeStream(string $fileName, $stream): void;

    public function has(string $path): bool;
}
