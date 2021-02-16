<?php

namespace Eds\Contractor\Persistence\Factory;

use DateTime;
use Eds\Contractor\Entity\ContractorGroup;
use Iterator;
use Nrg\Data\Collection;

class GroupFactory
{
    public function arrayToCreate(ContractorGroup $contractorGroup): array
    {
        return [
            'id' => $contractorGroup->getId(),
            'clientId' => $contractorGroup->getClient(),
            'creatorId' => $contractorGroup->getCreator(),
            'name' => $contractorGroup->getName(),
            'createdAt' => $contractorGroup->getCreatedAt()->format('Y-m-d h:i:s'),
            'updatedAt' => (null === $contractorGroup->getUpdatedAt()) ? null : $contractorGroup->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }

    public function arrayToUpdate(ContractorGroup $contractorGroup, array $fields = null): array
    {
        $contractorGroupArray = $this->arrayToCreate($contractorGroup);
        unset($contractorGroupArray['id']);

        return null === $fields ? $contractorGroupArray : array_filter(
            $contractorGroupArray,
            function ($field) use (&$fields) {
                return in_array($field, $fields);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    public function createEntity(array $data): ContractorGroup
    {
        $data['createdAt'] = new DateTime($data['createdAt'] ?? 'now');

        if (isset($data['updatedAt'])) {
            $data['updatedAt'] = new DateTime($data['updatedAt']);
        }

        $contractorGroup = new ContractorGroup(
            $data['id'],
            $data['clientId'],
            $data['creatorId'],
            $data['name'],
            $data['createdAt']
        );

        $contractorGroup->populateProps($data);

        return $contractorGroup;
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
