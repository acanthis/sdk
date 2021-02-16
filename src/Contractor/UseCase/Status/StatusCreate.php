<?php

namespace Eds\Contractor\UseCase\Status;

use Eds\Contractor\Entity\ContractorStatus;
use Eds\Contractor\Persistence\Abstraction\Repository\StatusRepositoryInterface;
use Eds\Contractor\Persistence\Factory\StatusFactory;
use Nrg\Utility\Abstraction\UuidGenerator;

class StatusCreate
{
    private StatusRepositoryInterface $statusRepository;
    private StatusFactory $statusFactory;
    private UuidGenerator $uuid;

    public function __construct(
        StatusRepositoryInterface $statusRepository,
        StatusFactory $statusFactory,
        UuidGenerator $uuid
    ) {
        $this->statusRepository = $statusRepository;
        $this->statusFactory = $statusFactory;
        $this->uuid = $uuid;
    }

    public function execute(array $data): ContractorStatus
    {
        $data['id'] = $this->uuid->generateV4();

        $contractorStatus = $this->statusFactory->createEntity($data);
        $this->statusRepository->create($contractorStatus);

        return $contractorStatus;
    }
}
