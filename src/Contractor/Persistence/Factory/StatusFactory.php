<?php

namespace Eds\Contractor\Persistence\Factory;

use DateTime;
use Eds\Contractor\Entity\ContractorStatus;
use Iterator;
use Nrg\Data\Collection;

class StatusFactory
{
    public function arrayToCreate(ContractorStatus $contractorStatus): array
    {
        return [
            'id' => $contractorStatus->getId(),
            'clientId' => $contractorStatus->getClient(),
            'creatorId' => $contractorStatus->getCreator(),
            'name' => $contractorStatus->getName(),
            'color' => $contractorStatus->getColor(),
            'createdAt' => $contractorStatus->getCreatedAt()->format('Y-m-d h:i:s'),
            'updatedAt' => (null === $contractorStatus->getUpdatedAt()) ? null : $contractorStatus->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }

    public function arrayToUpdate(ContractorStatus $contractorStatus, array $fields = null): array
    {
        $contractorStatusArray = $this->arrayToCreate($contractorStatus);
        unset($contractorStatusArray['id']);

        return null === $fields ? $contractorStatusArray : array_filter(
            $contractorStatusArray,
            function ($field) use (&$fields) {
                return in_array($field, $fields);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    public function createEntity(array $data): ContractorStatus
    {
        $data['createdAt'] = new DateTime($data['createdAt'] ?? 'now');

        if (isset($data['updatedAt'])) {
            $data['updatedAt'] = new DateTime($data['updatedAt']);
        }

        $contractorStatus = new ContractorStatus(
            $data['id'],
            $data['clientId'],
            $data['creatorId'],
            $data['name'],
            $data['color'],
            $data['createdAt']
        );

        $contractorStatus->populateProps($data);

        return $contractorStatus;
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
