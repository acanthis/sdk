<?php

namespace Eds\Contractor\UseCase\Contractor;

use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Entity\Contractor;
use Eds\Contractor\Persistence\Abstraction\Repository\ContractorRepositoryInterface;

class ContractorArchive
{
    private ContractorRepositoryInterface $contractorRepository;

    public function __construct(ContractorRepositoryInterface $contractorRepository)
    {
        $this->contractorRepository = $contractorRepository;
    }

    public function execute(array $data): Contractor
    {
        $contractor = $this->contractorRepository->findOne(new IdFilter($data['id']));

        if ($contractor->isArchive() !== $data['isArchive']) {
            $contractor->populateProps($data);
            $this->contractorRepository->update($contractor, array_keys($data));
        }

        return $contractor;
    }
}
