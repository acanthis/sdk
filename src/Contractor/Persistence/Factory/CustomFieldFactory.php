<?php

namespace Eds\Contractor\Persistence\Factory;

use DateTime;
use Eds\Contractor\Entity\ContractorCustomField;
use Eds\CustomFields\Value\CustomFieldType;
use Iterator;
use Nrg\Data\Collection;

class CustomFieldFactory
{
    public function arrayToCreate(ContractorCustomField $contractorCustomField): array
    {
        return [
            'id' => $contractorCustomField->getId(),
            'clientId' => $contractorCustomField->getClient(),
            'creatorId' => $contractorCustomField->getCreator(),
            'name' => $contractorCustomField->getName(),
            'type' => $contractorCustomField->getType(),
            'description' => $contractorCustomField->getDescription(),
            'isRequiredOnCreate' => $contractorCustomField->isRequiredOnCreate() ? 1 : 0,
            'isRequiredOnUpdate' => $contractorCustomField->isRequiredOnUpdate() ? 1 : 0,
            'isShowOnCreate' => $contractorCustomField->isShowOnCreate() ? 1 : 0,
            'isShowOnUpdate' => $contractorCustomField->isShowOnUpdate() ? 1 : 0,
            'isUnique' => $contractorCustomField->isUnique() ? 1 : 0,
            'isUseInFilter' => $contractorCustomField->isUseInFilter() ? 1 : 0,
            'isMarkOnDelete' => $contractorCustomField->isMarkOnDelete() ? 1 : 0,
            'attributes' => $contractorCustomField->getAttributes(),
            'createdAt' => $contractorCustomField->getCreatedAt()->format('Y-m-d h:i:s'),
            'updatedAt' => (null === $contractorCustomField->getUpdatedAt()) ? null : $contractorCustomField->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }

    public function arrayToUpdate(ContractorCustomField $contractorCustomField, array $fields = null): array
    {
        $contractorCustomFieldArray = $this->arrayToCreate($contractorCustomField);

        unset($contractorCustomFieldArray['id']);

        return null === $fields ? $contractorCustomFieldArray : array_filter(
            $contractorCustomFieldArray,
            function ($field) use (&$fields) {
                return in_array($field, $fields);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    public function createEntity(array $data): ContractorCustomField
    {
        $data['createdAt'] = new DateTime($data['createdAt'] ?? 'now');

        if (isset($data['updatedAt'])) {
            $data['updatedAt'] = new DateTime($data['updatedAt']);
        }

        $contractorCustomField = new ContractorCustomField(
            $data['id'],
            $data['clientId'],
            $data['creatorId'],
            $data['name'],
            $data['type'],
            $data['isRequiredOnCreate'],
            $data['isRequiredOnUpdate'],
            $data['isShowOnCreate'],
            $data['isShowOnUpdate'],
            $data['isUnique'],
            $data['isUseInFilter'],
            $data['createdAt']
        );

        $contractorCustomField->populateProps($data);

        return $contractorCustomField;
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
