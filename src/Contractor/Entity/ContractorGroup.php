<?php

namespace Eds\Contractor\Entity;

use DateTime;
use JsonSerializable;
use Nrg\Utility\PopulateProps;

class ContractorGroup implements JsonSerializable
{
    use PopulateProps;

    private string $id;
    private string $client;
    private string $creator;
    private string $name;
    private DateTime $createdAt;
    private ?DateTime $updatedAt = null;

    public function __construct(
        string $id,
        string $client,
        string $creator,
        string $name,
        DateTime $createdAt
    ) {
        $this->id = $id;
        $this->client = $client;
        $this->creator = $creator;
        $this->name = $name;
        $this->createdAt = $createdAt;
    }

    public function jsonSerialize(): array
    {
        return  [
            'id' => $this->getId(),
            'clientId' => $this->getClient(),
            'creatorId' => $this->getCreator(),
            'name' => $this->getName(),
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

    public function setClient(string $client): ContractorGroup
    {
        $this->client = $client;

        return $this;
    }

    public function getCreator(): string
    {
        return $this->creator;
    }

    public function setCreator(string $creator): ContractorGroup
    {
        $this->creator = $creator;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ContractorGroup
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): ContractorGroup
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): ContractorGroup
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
