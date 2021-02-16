<?php

namespace Eds\Contractor\UseCase\Status;

use Eds\Contractor\Persistence\Abstraction\Repository\StatusRepositoryInterface;
use Nrg\Data\Collection;

class StatusList
{
    private StatusRepositoryInterface $statusRepository;

    public function __construct(StatusRepositoryInterface $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function execute(object ...$dtoList): Collection
    {
        return $this->statusRepository->findAll(...$dtoList);
    }
}
