<?php

namespace Eds\Contractor\UseCase\PackageDoc;

use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Entity\ContractorPackageDoc;
use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocRepositoryInterface;

class PackageDocRead
{
    private PackageDocRepositoryInterface $packageDocRepository;

    public function __construct(PackageDocRepositoryInterface $packageDocRepository)
    {
        $this->packageDocRepository = $packageDocRepository;
    }

    public function execute(array $data): ContractorPackageDoc
    {
        return $this->packageDocRepository->findOne(new IdFilter($data['id']));
    }
}
