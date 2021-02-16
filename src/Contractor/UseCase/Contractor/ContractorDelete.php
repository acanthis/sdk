<?php

namespace Eds\Contractor\UseCase\Contractor;

use Eds\Contractor\Entity\Contractor;
use Eds\Contractor\Persistence\Abstraction\Repository\ContractorRepositoryInterface;
use LogicException;
use Nrg\Data\Dto\Filtering;

class ContractorDelete
{
    private ContractorRepositoryInterface $contractorRepository;

    public function __construct(ContractorRepositoryInterface $contractorRepository)
    {
        $this->contractorRepository = $contractorRepository;
    }

    public function execute(array $data): Contractor
    {
        $filter = (new Filtering($data))->getFilter();

        if ($filter->isEmpty()) {
            throw new LogicException('Filter cannot be empty');
        }

        $contractor = $this->contractorRepository->findOne($filter);
        $this->contractorRepository->delete($filter);

        return $contractor;
    }
}
