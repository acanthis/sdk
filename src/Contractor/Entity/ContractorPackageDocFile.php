<?php

namespace Eds\Contractor\Entity;

use DateTime;
use JsonSerializable;
use Nrg\Utility\PopulateProps;
use Nrg\Utility\Value\Size;

class ContractorPackageDocFile implements JsonSerializable
{
    use PopulateProps;

    private string $id;
    private string $packageDoc;
    private string $creator;
    private string $filePath;
    private string $originalName;
    private int $size;
    private string $mimeType;
    private DateTime $createdAt;
    private ?DateTime $updatedAt = null;

    public function __construct(
        string $id,
        string $packageDoc,
        string $creator,
        string $originalName,
        string $filePath,
        int $size,
        string $mimeType,
        DateTime $createdAt
    ) {
        $this->id = $id;
        $this->packageDoc = $packageDoc;
        $this->creator = $creator;
        $this->originalName = $originalName;
        $this->filePath = $filePath;
        $this->size = $size;
        $this->mimeType = $mimeType;
        $this->createdAt = $createdAt;
    }

    public function jsonSerialize(): array
    {
        return  [
            'id' => $this->getId(),
            'packageDocId' => $this->getPackageDoc(),
            'creatorId' => $this->getCreator(),
            'originalName' => $this->getOriginalName(),
            'filePath' => $this->getFilePath(),
            'size' => (new Size($this->getSize()))->toHumanString(),
            'mimeType' => $this->getMimeType(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d h:i'),
            'updatedAt' => (null === $this->getUpdatedAt()) ? null : $this->getUpdatedAt()->format('Y-m-d H:i'),
        ];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPackageDoc(): string
    {
        return $this->packageDoc;
    }

    public function setPackageDoc(string $packageDoc): ContractorPackageDocFile
    {
        $this->packageDoc = $packageDoc;

        return $this;
    }

    public function getCreator(): string
    {
        return $this->creator;
    }

    public function setCreator(string $creator): ContractorPackageDocFile
    {
        $this->creator = $creator;

        return $this;
    }

    public function setOriginalName(string $originalName): ContractorPackageDocFile
    {
        $this->originalName = $originalName;
        return $this;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): ContractorPackageDocFile
    {
        $this->filePath = $filePath;

        return $this;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): ContractorPackageDocFile
    {
        $this->size = $size;

        return $this;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): ContractorPackageDocFile
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): ContractorPackageDocFile
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): ContractorPackageDocFile
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
