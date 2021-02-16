<?php

namespace Eds\Contractor\UseCase\Status;

use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Entity\ContractorStatus;
use Eds\Contractor\Persistence\Abstraction\Repository\StatusRepositoryInterface;

class StatusRead
{
    private StatusRepositoryInterface $statusRepository;

    public function __construct(StatusRepositoryInterface $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function execute(array $data): ContractorStatus
    {
        return $this->statusRepository->findOne(new IdFilter($data['id']));
    }
}
