<?php

namespace Eds\Contractor\Entity;

use DateTime;
use JsonSerializable;
use Nrg\Utility\PopulateProps;

class ContractorContact implements JsonSerializable
{
    use PopulateProps;

    private string $id;
    private string $contractor;
    private string $creator;
    private string $name;
    private bool $isDefault = false;
    private ?string $post = null;
    private ?string $phone = null;
    private ?string $email = null;
    private ?string $note = null;
    private DateTime $createdAt;
    private ?DateTime $updatedAt = null;

    public function __construct(
        string $id,
        string $contractor,
        string $creator,
        string $name,
        bool $isDefault,
        DateTime $createdAt
    ) {
        $this->id = $id;
        $this->contractor = $contractor;
        $this->creator = $creator;
        $this->name = $name;
        $this->isDefault = $isDefault;
        $this->createdAt = $createdAt;
    }

    public function jsonSerialize(): array
    {
        return  [
            'id' => $this->getId(),
            'contractorId' => $this->getContractor(),
            'creatorId' => $this->getCreator(),
            'name' => $this->getName(),
            'post' => $this->getPost(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'note' => $this->getNote(),
            'isDefault' => $this->isDefault(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d h:i:s'),
            'updatedAt' => (null === $this->getUpdatedAt()) ? null : $this->getUpdatedAt()->format('Y-m-d H:i:s'),
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

    public function setContractor(string $contractor): ContractorContact
    {
        $this->contractor = $contractor;

        return $this;
    }

    public function getCreator(): string
    {
        return $this->creator;
    }

    public function setCreator(string $creator): ContractorContact
    {
        $this->creator = $creator;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ContractorContact
    {
        $this->name = $name;

        return $this;
    }

    public function isDefault(): bool
    {
        return $this->isDefault;
    }

    public function setIsDefault(bool $isDefault): ContractorContact
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    public function getPost(): ?string
    {
        return $this->post;
    }

    public function setPost(?string $post): ContractorContact
    {
        $this->post = $post;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): ContractorContact
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): ContractorContact
    {
        $this->email = $email;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): ContractorContact
    {
        $this->note = $note;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): ContractorContact
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): ContractorContact
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
