<?php

namespace Eds\Contractor\Persistence\Factory;

use DateTime;
use Eds\Contractor\Entity\Contractor;
use Eds\Contractor\Value\ContractorType;
use Iterator;
use Nrg\Data\Collection;

class ContractorFactory
{
    public function arrayToCreate(Contractor $contractor): array
    {
        return [
            'id' => $contractor->getId(),
            'clientId' => $contractor->getClient(),
            'creatorId' => $contractor->getCreator(),
            'statusId' => $contractor->getStatus(),
            'type' => $contractor->getType()->getValue(),
            'shortName' => $contractor->getShortName(),
            'fullName' => $contractor->getFullName(),
            'code' => $contractor->getCode(),
            'inn' => $contractor->getInn(),
            'kpp' => $contractor->getKpp(),
            'ogrn' => $contractor->getOgrn(),
            'ogrnIp' => $contractor->getOgrnIp(),
            'okpo' => $contractor->getOkpo(),
            'numberOfCertificate' => $contractor->getNumberOfCertificate(),
            'dateOfCertificate' => (null === $contractor->getDateOfCertificate()) ? null : $contractor->getDateOfCertificate()->format('d.m.Y'),
            'phone' => $contractor->getPhone(),
            'phoneMobile' => $contractor->getPhoneMobile(),
            'fax' => $contractor->getFax(),
            'email' => $contractor->getEmail(),
            'url' => $contractor->getUrl(),
            'legalAddress' => $contractor->getLegalAddress(),
            'actualAddress' => $contractor->getActualAddress(),
            'registrationAddress' => $contractor->getRegistrationAddress(),
            'note' => $contractor->getNote(),
            'isArchive' => $contractor->isArchive() ? 1 : 0,
            'createdAt' => $contractor->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => (null === $contractor->getUpdatedAt()) ? null : $contractor->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }

    public function arrayToUpdate(Contractor $contractor, array $fields = null): array
    {
        $contractorArray = $this->arrayToCreate($contractor);

        unset($contractorArray['id']);

        return null === $fields ? $contractorArray : array_filter(
            $contractorArray,
            function ($field) use (&$fields) {
                return in_array($field, $fields);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    public function createEntity(array $data): Contractor
    {
        $data['type'] = new ContractorType($data['type']);
        $data['createdAt'] = new DateTime($data['createdAt'] ?? 'now');

        if (isset($data['updatedAt'])) {
            $data['updatedAt'] = new DateTime($data['updatedAt']);
        }

        if (isset($data['dateOfCertificate'])) {
            $data['dateOfCertificate'] = new DateTime($data['dateOfCertificate']);
        }

        $contractor = new Contractor(
            $data['id'],
            $data['clientId'], // TODO заменить на реальный
            $data['creatorId'], // TODO заменить на реальный
            $data['type'],
            $data['shortName'],
            $data['createdAt']
        );

        $contractor->populateProps($data);

        return $contractor;
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
