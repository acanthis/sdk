<?php

namespace Eds\Contractor\UseCase\PackageDocFile;

use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Entity\ContractorPackageDocFile;
use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocFileRepositoryInterface;

class PackageDocFileRead
{
    private PackageDocFileRepositoryInterface $packageDocFileRepository;

    public function __construct(PackageDocFileRepositoryInterface $packageDocFileRepository)
    {
        $this->packageDocFileRepository = $packageDocFileRepository;
    }

    public function execute(array $data): ContractorPackageDocFile
    {
        return $this->packageDocFileRepository->findOne(new IdFilter($data['id']));
    }
}
