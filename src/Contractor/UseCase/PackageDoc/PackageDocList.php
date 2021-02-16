<?php

namespace Eds\Contractor\UseCase\PackageDoc;

use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocRepositoryInterface;
use Nrg\Data\Collection;

class PackageDocList
{
    private PackageDocRepositoryInterface $packageDocRepository;

    public function __construct(PackageDocRepositoryInterface $packageDocRepository)
    {
        $this->packageDocRepository = $packageDocRepository;
    }

    public function execute(object ...$dtoList): Collection
    {
        return $this->packageDocRepository->findAll(...$dtoList);
    }
}
