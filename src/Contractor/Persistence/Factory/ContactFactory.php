<?php

namespace Eds\Contractor\Persistence\Factory;

use DateTime;
use Eds\Contractor\Entity\ContractorContact;
use Iterator;
use Nrg\Data\Collection;

class ContactFactory
{
    public function arrayToCreate(ContractorContact $contractorContact): array
    {
        return [
            'id' => $contractorContact->getId(),
            'contractorId' => $contractorContact->getContractor(),
            'creatorId' => $contractorContact->getCreator(),
            'name' => $contractorContact->getName(),
            'post' => $contractorContact->getPost(),
            'phone' => $contractorContact->getPhone(),
            'email' => $contractorContact->getEmail(),
            'note' => $contractorContact->getNote(),
            'isDefault' => $contractorContact->isDefault() ? 1 : 0,
            'createdAt' => $contractorContact->getCreatedAt()->format('Y-m-d h:i:s'),
            'updatedAt' => (null === $contractorContact->getUpdatedAt()) ? null : $contractorContact->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }

    public function arrayToUpdate(ContractorContact $contractorContact, array $fields = null): array
    {
        $contractorContactArray = $this->arrayToCreate($contractorContact);

        unset($contractorContactArray['id']);

        return null === $fields ? $contractorContactArray : array_filter(
            $contractorContactArray,
            function ($field) use (&$fields) {
                return in_array($field, $fields);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    public function createEntity(array $data): ContractorContact
    {
        $data['createdAt'] = new DateTime($data['createdAt'] ?? 'now');

        if (isset($data['updatedAt'])) {
            $data['updatedAt'] = new DateTime($data['updatedAt']);
        }

        $contractorContact = new ContractorContact(
            $data['id'],
            $data['contractorId'],
            $data['creatorId'],
            $data['name'],
            $data['isDefault'],
            $data['createdAt']
        );

        $contractorContact->populateProps($data);

        return $contractorContact;
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
