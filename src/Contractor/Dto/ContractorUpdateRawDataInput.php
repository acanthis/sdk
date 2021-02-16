<?php

namespace Eds\Contractor\Dto;

use Nrg\Utility\Service\PseudoRandomUuidGenerator;

class ContractorUpdateRawDataInput
{
    private array $data = [];
    private array $customFieldData = [];

    public function __construct(array $data)
    {
        $uuidGenerator = new PseudoRandomUuidGenerator();

        foreach ($data as $fieldId => $value) {
            if ($uuidGenerator->isValidV4($fieldId)) {
                $this->customFieldData[$fieldId] = $value;
            } else {
                $this->data[$fieldId] = $value;
            }
        }
    }

    public function dataToArray(): array
    {
        return $this->data;
    }

    public function customFieldDataToArray(): array
    {
        return $this->customFieldData;
    }

    public function hasChanged(array $prevData): bool
    {
        foreach ($this->data as $field => $value) {
            if ($prevData[$field] !== $value) {
                return true;
            }
        }

        return false;
    }
}
