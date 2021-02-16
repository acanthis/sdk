<?php

namespace Eds\Contractor\UseCase\PackageDocFile;

use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocFileRepositoryInterface;
use Nrg\Data\Collection;

class PackageDocFileList
{
    private PackageDocFileRepositoryInterface $packageDocFileRepository;

    public function __construct(PackageDocFileRepositoryInterface $packageDocFileRepository)
    {
        $this->packageDocFileRepository = $packageDocFileRepository;
    }

    public function execute(object ...$dtoList): Collection
    {
        return $this->packageDocFileRepository->findAll(...$dtoList);
    }
}
