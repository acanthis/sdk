<?php

namespace Eds\Contractor\Persistence\Factory;

use DateTime;
use Eds\Contractor\Entity\ContractorPackageDoc;
use Iterator;
use Nrg\Data\Collection;

class PackageDocFactory
{
    public function arrayToCreate(ContractorPackageDoc $contractorPackageDoc): array
    {
        return [
            'id' => $contractorPackageDoc->getId(),
            'contractorId' => $contractorPackageDoc->getContractor(),
            'creatorId' => $contractorPackageDoc->getCreator(),
            'name' => $contractorPackageDoc->getName(),
            'expire' => $contractorPackageDoc->getExpire()->format('Y-m-d h:i'),
            'createdAt' => $contractorPackageDoc->getCreatedAt()->format('Y-m-d h:i'),
            'updatedAt' => (null === $contractorPackageDoc->getUpdatedAt()) ? null : $contractorPackageDoc->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }

    public function arrayToUpdate(ContractorPackageDoc $contractorPackageDoc, array $fields = null): array
    {
        $contractorPackageDocArray = $this->arrayToCreate($contractorPackageDoc);

        unset($contractorPackageDocArray['id']);

        return null === $fields ? $contractorPackageDocArray : array_filter(
            $contractorPackageDocArray,
            function ($field) use (&$fields) {
                return in_array($field, $fields);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    public function createEntity(array $data): ContractorPackageDoc
    {
        $data['createdAt'] = new DateTime($data['createdAt'] ?? 'now');

        if (isset($data['updatedAt'])) {
            $data['updatedAt'] = new DateTime($data['updatedAt']);
        }

        if (isset($data['expire'])) {
            $data['expire'] = new DateTime($data['expire']);
        }

        $contractorPackageDoc = new ContractorPackageDoc(
            $data['id'],
            $data['contractorId'],
            $data['creatorId'],
            $data['name'],
            $data['expire'],
            $data['createdAt']
        );

        $contractorPackageDoc->populateProps($data);

        return $contractorPackageDoc;
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
