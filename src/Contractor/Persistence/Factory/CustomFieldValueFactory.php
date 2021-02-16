<?php

namespace Eds\Contractor\Persistence\Factory;

use Eds\Contractor\Entity\ContractorCustomFieldValue;
use Iterator;
use Nrg\Data\Collection;

class CustomFieldValueFactory
{
    public function arrayToCreate(ContractorCustomFieldValue $contractorCustomFieldValue): array
    {
        $result =  [
            'id' => $contractorCustomFieldValue->getId(),
            'customFieldId' => $contractorCustomFieldValue->getCustomField(),
            'contractorId' => $contractorCustomFieldValue->getContractor(),
            'value' => $contractorCustomFieldValue->getValue(),
        ];

        if (is_bool($contractorCustomFieldValue->getValue())) {
            $result['value'] = $contractorCustomFieldValue->getValue() ? 1 : 0;
        }

        return $result;
    }

    public function arrayToUpdate(ContractorCustomFieldValue $contractorCustomFieldValue, array $fields = null): array
    {
        $contractorCustomFieldValueArray = $this->arrayToCreate($contractorCustomFieldValue);

        unset($contractorCustomFieldValueArray['id']);

        return null === $fields ? $contractorCustomFieldValueArray : array_filter(
            $contractorCustomFieldValueArray,
            function ($field) use (&$fields) {
                return in_array($field, $fields);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    public function createEntity(array $data): ContractorCustomFieldValue
    {
        $contractorCustomFieldValue = new ContractorCustomFieldValue(
            $data['id'],
            $data['customFieldId'],
            $data['contractorId'],
            $data['value']
        );

        $contractorCustomFieldValue->populateProps($data);

        return $contractorCustomFieldValue;
    }

    public function createCollection(Iterator $iterator): Collection
    {
        $collection = new Collection();

        foreach ($iterator as $data) {
            $collection->addEntity($this->createEntity($data));
        }

        return $collection;
    }
}
