<?php

namespace Eds\CustomFields\Entity;

use DateTime;
use Eds\CustomFields\Value\CustomFieldType;
use JsonSerializable;
use Nrg\Utility\PopulateProps;

class BaseCustomField implements JsonSerializable
{
    use PopulateProps;

    private string $id;
    private string $client;
    private string $creator;
    private string $name;
    private string $type;
    private string $description;
    private bool $isRequiredOnCreate;
    private bool $isRequiredOnUpdate;
    private bool $isShowOnCreate;
    private bool $isShowOnUpdate;
    private bool $isUnique;
    private bool $isUseInFilter;
    private bool $isMarkOnDelete = false;
    private ?string $attributes = null;
    private DateTime $createdAt;
    private ?DateTime $updatedAt = null;

    public function __construct(
        string $id,
        string $client,
        string $creator,
        string $name,
        string $type,
        bool $isRequiredOnCreate,
        bool $isRequiredOnUpdate,
        bool $isShowOnCreate,
        bool $isShowOnUpdate,
        bool $isUnique,
        bool $isUseInFilter,
        DateTime $createdAt
    ) {
        $this->id = $id;
        $this->client = $client;
        $this->creator = $creator;
        $this->name = $name;
        $this->type = $type;
        $this->isRequiredOnCreate = $isRequiredOnCreate;
        $this->isRequiredOnUpdate = $isRequiredOnUpdate;
        $this->isShowOnCreate = $isShowOnCreate;
        $this->isShowOnUpdate = $isShowOnUpdate;
        $this->isUnique = $isUnique;
        $this->isUseInFilter = $isUseInFilter;
        $this->createdAt = $createdAt;
    }

    public function jsonSerialize(): array
    {
        return  [
            'id' => $this->getId(),
            'clientId' => $this->getClient(),
            'creatorId' => $this->getCreator(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'description' => $this->getDescription(),
            'isRequiredOnCreate' => $this->isRequiredOnCreate(),
            'isRequiredOnUpdate' => $this->isRequiredOnUpdate(),
            'isShowOnCreate' => $this->isShowOnCreate(),
            'isShowOnUpdate' => $this->isShowOnUpdate(),
            'isUnique' => $this->isUnique(),
            'isUseInFilter' => $this->isUseInFilter(),
            'isMarkOnDelete' => $this->isMarkOnDelete(),
            'attributes' => $this->getAttributes(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d h:i:s'),
            'updatedAt' => (null === $this->getUpdatedAt()) ? null : $this->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getClient(): string
    {
        return $this->client;
    }

    public function setClient(string $client): BaseCustomField
    {
        $this->client = $client;

        return $this;
    }

    public function getCreator(): string
    {
        return $this->creator;
    }

    public function setCreator(string $creator): BaseCustomField
    {
        $this->creator = $creator;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): BaseCustomField
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): BaseCustomField
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): BaseCustomField
    {
        $this->description = $description;

        return $this;
    }

    public function isRequiredOnCreate(): bool
    {
        return $this->isRequiredOnCreate;
    }

    public function setIsRequiredOnCreate(bool $isRequiredOnCreate): BaseCustomField
    {
        $this->isRequiredOnCreate = $isRequiredOnCreate;

        return $this;
    }

    public function isRequiredOnUpdate(): bool
    {
        return $this->isRequiredOnUpdate;
    }

    public function setIsRequiredOnUpdate(bool $isRequiredOnUpdate): BaseCustomField
    {
        $this->isRequiredOnUpdate = $isRequiredOnUpdate;

        return $this;
    }

    public function isShowOnCreate(): bool
    {
        return $this->isShowOnCreate;
    }

    public function setIsShowOnCreate(bool $isShowOnCreate): BaseCustomField
    {
        $this->isShowOnCreate = $isShowOnCreate;

        return $this;
    }

    public function isShowOnUpdate(): bool
    {
        return $this->isShowOnUpdate;
    }

    public function setIsShowOnUpdate(bool $isShowOnUpdate): BaseCustomField
    {
        $this->isShowOnUpdate = $isShowOnUpdate;

        return $this;
    }

    public function isUnique(): bool
    {
        return $this->isUnique;
    }

    public function setIsUnique(bool $isUnique): BaseCustomField
    {
        $this->isUnique = $isUnique;

        return $this;
    }

    public function isUseInFilter(): bool
    {
        return $this->isUseInFilter;
    }

    public function setIsUseInFilter(bool $isUseInFilter): BaseCustomField
    {
        $this->isUseInFilter = $isUseInFilter;

        return $this;
    }

    public function isMarkOnDelete(): bool
    {
        return $this->isMarkOnDelete;
    }

    public function setIsMarkOnDelete(bool $isMarkOnDelete): BaseCustomField
    {
        $this->isMarkOnDelete = $isMarkOnDelete;

        return $this;
    }

    public function getAttributes():? string
    {
        return $this->attributes;
    }

    public function setAttributes(?string $attributes): BaseCustomField
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): BaseCustomField
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): BaseCustomField
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
