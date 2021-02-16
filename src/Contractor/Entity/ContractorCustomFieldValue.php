<?php

namespace Eds\Contractor\Entity;

use JsonSerializable;
use Nrg\Utility\PopulateProps;

class ContractorCustomFieldValue implements JsonSerializable
{
    use PopulateProps;

    private string $id;
    private string $customField;
    private string $contractor;
    /** @var mixed */
    private $value;

    public function __construct(string $id, string $customField, string $contractor, $value)
    {
        $this->id = $id;
        $this->customField = $customField;
        $this->contractor = $contractor;
        $this->value = $value;
    }

    public function jsonSerialize(): array
    {
        return  [
            'id' => $this->getId(),
            'customFieldId' => $this->getCustomField(),
            'contractorId' => $this->getContractor(),
            'value' => $this->getValue(),
        ];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCustomField(): string
    {
        return $this->customField;
    }

    public function setCustomField(string $customField): ContractorCustomFieldValue
    {
        $this->customField = $customField;

        return $this;
    }

    public function getContractor(): string
    {
        return $this->contractor;
    }

    public function setContractor(string $contractor): ContractorCustomFieldValue
    {
        $this->contractor = $contractor;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): ContractorCustomFieldValue
    {
        $this->value = $value;

        return $this;
    }
}
