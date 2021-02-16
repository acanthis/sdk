<?php

namespace Eds\Contractor\UseCase\PackageDoc;

use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocRepositoryInterface;
use LogicException;
use Nrg\Data\Dto\Filtering;

class PackageDocDelete
{
    private PackageDocRepositoryInterface $packageDocRepository;

    public function __construct(PackageDocRepositoryInterface $packageDocRepository)
    {
        $this->packageDocRepository = $packageDocRepository;
    }

    public function execute(array $data): int
    {
        $filter = (new Filtering($data))->getFilter();

        if ($filter->isEmpty()) {
            throw new LogicException('Filter cannot be empty');
        }

        return $this->packageDocRepository->delete($filter);
    }
}
