<?php

namespace Eds\Contractor\UseCase\Contractor;

use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Entity\Contractor;
use Eds\Contractor\Persistence\Abstraction\Repository\ContractorRepositoryInterface;

class ContractorRead
{
    private ContractorRepositoryInterface $contractorRepository;

    public function __construct(ContractorRepositoryInterface $contractorRepository)
    {
        $this->contractorRepository = $contractorRepository;
    }

    public function execute(array $data): Contractor
    {
        return $this->contractorRepository->findOne(new IdFilter($data['id']));
    }
}
