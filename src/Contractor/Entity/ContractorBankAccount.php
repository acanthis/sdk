<?php

namespace Eds\Contractor\Entity;

use DateTime;
use JsonSerializable;
use Nrg\Utility\PopulateProps;

class ContractorBankAccount implements JsonSerializable
{
    use PopulateProps;

    private string $id;
    private string $contractor;
    private string $creator;
    private string $checkingAccount;
    private bool $isDefault = false;
    private ?string $bankIdentificationCode = null;
    private ?string $correspondentAccount = null;
    private ?string $bankName = null;
    private ?string $bankAddress = null;
    private ?string $note = null;
    private DateTime $createdAt;
    private ?DateTime $updatedAt = null;

    public function __construct(
        string $id,
        string $contractor,
        string $creator,
        string $checkingAccount,
        bool $isDefault,
        DateTime $createdAt
    ) {
        $this->id = $id;
        $this->contractor = $contractor;
        $this->creator = $creator;
        $this->checkingAccount = $checkingAccount;
        $this->isDefault = $isDefault;
        $this->createdAt = $createdAt;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'contractorId' => $this->getContractor(),
            'creatorId' => $this->getCreator(),
            'checkingAccount' => $this->getCheckingAccount(),
            'bankIdentificationCode' => $this->getBankIdentificationCode(),
            'correspondentAccount' => $this->getCorrespondentAccount(),
            'bankName' => $this->getBankName(),
            'bankAddress' => $this->getBankAddress(),
            'isDefault' => $this->isDefault(),
            'note' => $this->getNote(),
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

    public function setContractor(string $contractor): ContractorBankAccount
    {
        $this->contractor = $contractor;

        return $this;
    }

    public function getCreator(): string
    {
        return $this->creator;
    }

    public function setCreator(string $creator): ContractorBankAccount
    {
        $this->creator = $creator;

        return $this;
    }

    public function getCheckingAccount(): string
    {
        return $this->checkingAccount;
    }

    public function setCheckingAccount(string $checkingAccount): ContractorBankAccount
    {
        $this->checkingAccount = $checkingAccount;

        return $this;
    }

    public function isDefault(): bool
    {
        return $this->isDefault;
    }

    public function setIsDefault(bool $isDefault): ContractorBankAccount
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    public function getBankIdentificationCode(): ?string
    {
        return $this->bankIdentificationCode;
    }

    public function setBankIdentificationCode(?string $bankIdentificationCode): ContractorBankAccount
    {
        $this->bankIdentificationCode = $bankIdentificationCode;

        return $this;
    }

    public function getCorrespondentAccount(): ?string
    {
        return $this->correspondentAccount;
    }

    public function setCorrespondentAccount(?string $correspondentAccount): ContractorBankAccount
    {
        $this->correspondentAccount = $correspondentAccount;

        return $this;
    }

    public function getBankName(): ?string
    {
        return $this->bankName;
    }

    public function setBankName(?string $bankName): ContractorBankAccount
    {
        $this->bankName = $bankName;

        return $this;
    }

    public function getBankAddress(): ?string
    {
        return $this->bankAddress;
    }

    public function setBankAddress(?string $bankAddress): ContractorBankAccount
    {
        $this->bankAddress = $bankAddress;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): ContractorBankAccount
    {
        $this->note = $note;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): ContractorBankAccount
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): ContractorBankAccount
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
