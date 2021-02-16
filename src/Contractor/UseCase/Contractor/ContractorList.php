<?php

namespace Eds\Contractor\UseCase\Contractor;

use Eds\Contractor\Persistence\Abstraction\Repository\ContractorRepositoryInterface;
use Nrg\Data\Collection;

class ContractorList
{
    private ContractorRepositoryInterface $contractorRepository;

    public function __construct(ContractorRepositoryInterface $contractorRepository)
    {
        $this->contractorRepository = $contractorRepository;
    }

    public function execute(object ...$dtoList): Collection
    {
        return $this->contractorRepository->findAll(...$dtoList);
    }
}
