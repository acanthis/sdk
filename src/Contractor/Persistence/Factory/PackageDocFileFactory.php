<?php

namespace Eds\Contractor\Persistence\Factory;

use DateTime;
use Eds\Contractor\Entity\ContractorPackageDocFile;
use Iterator;
use Nrg\Data\Collection;

class PackageDocFileFactory
{
    public function arrayToCreate(ContractorPackageDocFile $contractorPackageDocFile): array
    {
        return [
            'id' => $contractorPackageDocFile->getId(),
            'packageDocId' => $contractorPackageDocFile->getPackageDoc(),
            'creatorId' => $contractorPackageDocFile->getCreator(),
            'originalName' => $contractorPackageDocFile->getOriginalName(),
            'filePath' => $contractorPackageDocFile->getFilePath(),
            'size' => $contractorPackageDocFile->getSize(),
            'mimeType' => $contractorPackageDocFile->getMimeType(),
            'createdAt' => $contractorPackageDocFile->getCreatedAt()->format('Y-m-d h:i'),
            'updatedAt' => (null === $contractorPackageDocFile->getUpdatedAt()) ? null : $contractorPackageDocFile->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }

    public function arrayToUpdate(ContractorPackageDocFile $contractorPackageDoc, array $fields = null): array
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

    public function createEntity(array $data): ContractorPackageDocFile
    {
        $data['createdAt'] = new DateTime($data['createdAt'] ?? 'now');

        if (isset($data['updatedAt'])) {
            $data['updatedAt'] = new DateTime($data['updatedAt']);
        }

        $contractorPackageDoc = new ContractorPackageDocFile(
            $data['id'],
            $data['packageDocId'],
            $data['creatorId'],
            $data['originalName'],
            $data['filePath'],
            $data['size'],
            $data['mimeType'],
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
