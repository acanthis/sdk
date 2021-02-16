<?php

namespace Eds\Contractor\Entity;

use DateTime;
use JsonSerializable;
use Nrg\Utility\PopulateProps;

class ContractorPackageDoc implements JsonSerializable
{
    use PopulateProps;

    private string $id;
    private string $contractor;
    private string $creator;
    private string $name;
    private DateTime $expire;
    private DateTime $createdAt;
    private ?DateTime $updatedAt = null;

    public function __construct(
        string $id,
        string $contractor,
        string $creator,
        string $name,
        DateTime $expire,
        DateTime $createdAt
    ) {
        $this->id = $id;
        $this->contractor = $contractor;
        $this->creator = $creator;
        $this->name = $name;
        $this->expire = $expire;
        $this->createdAt = $createdAt;
    }

    public function jsonSerialize(): array
    {
        return  [
            'id' => $this->getId(),
            'contractorId' => $this->getContractor(),
            'creatorId' => $this->getCreator(),
            'name' => $this->getName(),
            'expire' => $this->getExpire()->format('Y-m-d h:i'),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d h:i'),
            'updatedAt' => (null === $this->getUpdatedAt()) ? null : $this->getUpdatedAt()->format('Y-m-d H:i'),
        ];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getContractor(): string
    {
        return $this->contractor;
    }

    public function setContractor(string $contractor): ContractorPackageDoc
    {
        $this->contractor = $contractor;

        return $this;
    }

    public function getCreator(): string
    {
        return $this->creator;
    }

    public function setCreator(string $creator): ContractorPackageDoc
    {
        $this->creator = $creator;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ContractorPackageDoc
    {
        $this->name = $name;

        return $this;
    }

    public function setExpire(DateTime $expire): ContractorPackageDoc
    {
        $this->expire = $expire;

        return $this;
    }

    public function getExpire(): DateTime
    {
        return $this->expire;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): ContractorPackageDoc
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): ContractorPackageDoc
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
