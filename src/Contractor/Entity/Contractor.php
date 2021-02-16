<?php

namespace Eds\Contractor\Entity;

use DateTime;
use Eds\Contractor\Value\ContractorType;
use JsonSerializable;
use Nrg\Utility\PopulateProps;

class Contractor implements JsonSerializable
{
    use PopulateProps;

    private string $id;
    private string $client;
    private string $creator;
    private ContractorType $type;
    private string $shortName;
    private ?string $status = null;
    private ?string $inn = null;
    private ?string $fullName = null;
    private ?string $code = null;
    private ?string $kpp = null;
    private ?string $ogrn = null;
    private ?string $ogrnIp = null;
    private ?string $okpo = null;
    private ?string $numberOfCertificate = null;
    private ?DateTime $dateOfCertificate = null;
    private ?string $phone = null;
    private ?string $phoneMobile = null;
    private ?string $fax = null;
    private ?string $email = null;
    private ?string $url = null;
    private ?string $legalAddress = null;
    private ?string $actualAddress = null;
    private ?string $registrationAddress = null;
    private ?string $note = null;
    private bool $isArchive = false;
    private DateTime $createdAt;
    private ?DateTime $updatedAt = null;
    private int $contactsCount = 0;
    private int $bankAccountsCount = 0;
    private int $packageDocsFilesCount = 0;

    public function __construct(
        string $id,
        string $client,
        string $creator,
        ContractorType $type,
        string $shortName,
        DateTime $createdAt
    ) {
        $this->id = $id;
        $this->client = $client;
        $this->creator = $creator;
        $this->type = $type;
        $this->shortName = $shortName;
        $this->createdAt = $createdAt;
    }

    public function jsonSerialize(): array
    {
        return  [
            'id' => $this->getId(),
            'clientId' => $this->getClient(),
            'type' => $this->getType()->getValue(),
            'statusId' => $this->getStatus(),
            'creatorId' => $this->getCreator(),
            'shortName' => $this->getShortName(),
            'fullName' => $this->getFullName(),
            'code' => $this->getCode(),
            'inn' => $this->getInn(),
            'kpp' => $this->getKpp(),
            'ogrn' => $this->getOgrn(),
            'ogrnIp' => $this->getOgrnIp(),
            'okpo' => $this->getOkpo(),
            'numberOfCertificate' => $this->getNumberOfCertificate(),
            'dateOfCertificate' => (null === $this->getDateOfCertificate()) ? null : $this->getDateOfCertificate()->format('Y-m-d H:i:s'),
            'phone' => $this->getPhone(),
            'phoneMobile' => $this->getPhoneMobile(),
            'fax' => $this->getFax(),
            'email' => $this->getEmail(),
            'url' => $this->getUrl(),
            'legalAddress' => $this->getLegalAddress(),
            'actualAddress' => $this->getActualAddress(),
            'registrationAddress' => $this->getRegistrationAddress(),
            'note' => $this->getNote(),
            'isArchive' => $this->isArchive(),
            'contactsCount' => $this->getContactsCount(),
            'bankAccountsCount' => $this->getBankAccountsCount(),
            'packageDocsFilesCount' => $this->getPackageDocsFilesCount(),
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

    public function getCreator(): string
    {
        return $this->creator;
    }

    public function getType(): ContractorType
    {
        return $this->type;
    }

    public function getShortName(): string
    {
        return $this->shortName;
    }

    public function getInn():? string
    {
        return $this->inn;
    }

    public function getStatus():? string
    {
        return $this->status;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getKpp(): ?string
    {
        return $this->kpp;
    }

    public function getOgrn(): ?string
    {
        return $this->ogrn;
    }

    public function getOgrnIp(): ?string
    {
        return $this->ogrnIp;
    }

    public function getOkpo(): ?string
    {
        return $this->okpo;
    }

    public function getNumberOfCertificate(): ?string
    {
        return $this->numberOfCertificate;
    }

    public function getDateOfCertificate(): ?DateTime
    {
        return $this->dateOfCertificate;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getPhoneMobile(): ?string
    {
        return $this->phoneMobile;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getLegalAddress(): ?string
    {
        return $this->legalAddress;
    }

    public function getActualAddress(): ?string
    {
        return $this->actualAddress;
    }

    public function getRegistrationAddress(): ?string
    {
        return $this->registrationAddress;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function isArchive(): bool
    {
        return $this->isArchive;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function getContactsCount(): int
    {
        return $this->contactsCount;
    }

    public function getBankAccountsCount(): int
    {
        return $this->bankAccountsCount;
    }

    public function getPackageDocsFilesCount(): int
    {
        return $this->packageDocsFilesCount;
    }

    public function setStatus(?string $status): Contractor
    {
        $this->status = $status;

        return $this;
    }

    public function setFullName(?string $fullName): Contractor
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function setCode(?string $code): Contractor
    {
        $this->code = $code;

        return $this;
    }

    public function setKpp(?string $kpp): Contractor
    {
        $this->kpp = $kpp;

        return $this;
    }

    public function setOgrn(?string $ogrn): Contractor
    {
        $this->ogrn = $ogrn;

        return $this;
    }

    public function setOgrnIp(?string $ogrnIp): Contractor
    {
        $this->ogrnIp = $ogrnIp;

        return $this;
    }

    public function setOkpo(?string $okpo): Contractor
    {
        $this->okpo = $okpo;

        return $this;
    }

    public function setNumberOfCertificate(?string $numberOfCertificate): Contractor
    {
        $this->numberOfCertificate = $numberOfCertificate;

        return $this;
    }

    public function setDateOfCertificate(?DateTime $dateOfCertificate): Contractor
    {
        $this->dateOfCertificate = $dateOfCertificate;

        return $this;
    }

    public function setPhone(?string $phone): Contractor
    {
        $this->phone = $phone;

        return $this;
    }

    public function setPhoneMobile(?string $phoneMobile): Contractor
    {
        $this->phoneMobile = $phoneMobile;

        return $this;
    }

    public function setFax(?string $fax): Contractor
    {
        $this->fax = $fax;

        return $this;
    }

    public function setEmail(?string $email): Contractor
    {
        $this->email = $email;

        return $this;
    }

    public function setUrl(?string $url): Contractor
    {
        $this->url = $url;

        return $this;
    }

    public function setLegalAddress(?string $legalAddress): Contractor
    {
        $this->legalAddress = $legalAddress;

        return $this;
    }

    public function setActualAddress(?string $actualAddress): Contractor
    {
        $this->actualAddress = $actualAddress;

        return $this;
    }

    public function setRegistrationAddress(?string $registrationAddress): Contractor
    {
        $this->registrationAddress = $registrationAddress;

        return $this;
    }

    public function setNote(?string $note): Contractor
    {
        $this->note = $note;

        return $this;
    }

    public function setIsArchive(bool $isArchive): Contractor
    {
        $this->isArchive = $isArchive;

        return $this;
    }

    public function setUpdatedAt(?DateTime $updatedAt): Contractor
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function setContactsCount(int $contactsCount): Contractor
    {
        $this->contactsCount = $contactsCount;

        return $this;
    }

    public function setBankAccountsCount(int $bankAccountsCount): Contractor
    {
        $this->bankAccountsCount = $bankAccountsCount;

        return $this;
    }

    public function setPackageDocsFilesCount(int $packageDocsFilesCount): Contractor
    {
        $this->packageDocsFilesCount = $packageDocsFilesCount;

        return $this;
    }

    public function setClient(string $client): Contractor
    {
        $this->client = $client;

        return $this;
    }

    public function setCreator(string $creator): Contractor
    {
        $this->creator = $creator;

        return $this;
    }

    public function setType(ContractorType $type): Contractor
    {
        $this->type = $type;

        return $this;
    }

    public function setShortName(string $shortName): Contractor
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function setInn(?string $inn): Contractor
    {
        $this->inn = $inn;

        return $this;
    }

    public function setCreatedAt(DateTime $createdAt): Contractor
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
