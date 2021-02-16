<?php

namespace Nrg\Http\Value;

use InvalidArgumentException;
use RuntimeException;

class UploadedFile
{
    private ?string $name;

    private ?string $type;

    private ?string $tmpName;

    private ?int $error;

    private ?int $size;

    private bool $moved = false;

    private string $extension;

    public function __construct(string $name, string $type, string $tmpName, int $error, int $size)
    {
        $this->name = $name;
        $this->type = $type;
        $this->tmpName = $tmpName;
        $this->error = $error;
        $this->size = $size;
        $this->extension = pathinfo($this->name, PATHINFO_EXTENSION);
    }

    public function __toString(): ?string
    {
        return $this->name;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getError(): int
    {
        return $this->error;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTmpName(): ?string
    {
        return $this->tmpName;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function moveTo(string $targetPath)
    {
        if (UPLOAD_ERR_OK !== $this->error) {
            throw new RuntimeException('Cannot move file, the file has been loaded with an error');
        }
        if (empty($targetPath)) {
            throw new InvalidArgumentException('Invalid targetPath provided, must be a non-empty string');
        }
        if ($this->moved) {
            throw new RuntimeException('Cannot move file after it has already been moved');
        }
        if (empty(PHP_SAPI) || 0 === strpos(PHP_SAPI, 'cli')) {
            rename($this->tmpName, $targetPath);
        } else {
            if (!is_uploaded_file($this->tmpName)) {
                throw new RuntimeException('Cannot move file it was not uploaded via HTTP POST');
            }
            if (false === move_uploaded_file($this->tmpName, $targetPath)) {
                throw new RuntimeException('Error occurred during move operation');
            }
        }
        $this->moved = true;
    }
}
