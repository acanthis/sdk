<?php

namespace Eds\Contractor\UseCase\PackageDoc;

use Eds\Contractor\Entity\ContractorPackageDoc;
use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocRepositoryInterface;
use Eds\Contractor\Persistence\Factory\PackageDocFactory;
use Nrg\Utility\Abstraction\UuidGenerator;

class PackageDocCreate
{
    private PackageDocRepositoryInterface $packageDocRepository;
    private PackageDocFactory $packageDocFactory;
    private UuidGenerator $uuid;

    public function __construct(
        PackageDocRepositoryInterface $packageDocRepository,
        PackageDocFactory $packageDocFactory,
        UuidGenerator $uuid
    ) {
        $this->packageDocRepository = $packageDocRepository;
        $this->packageDocFactory = $packageDocFactory;
        $this->uuid = $uuid;
    }

    public function execute(array $data): ContractorPackageDoc
    {
        $data['id'] = $this->uuid->generateV4();
        $packageDoc = $this->packageDocFactory->createEntity($data);
        $this->packageDocRepository->create($packageDoc);

        return $packageDoc;
    }
}
