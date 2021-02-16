<?php

namespace Eds\Contractor\UseCase\Status;

use DateTime;
use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Dto\UpdateRawDataInput;
use Eds\Contractor\Entity\ContractorStatus;
use Eds\Contractor\Persistence\Abstraction\Repository\StatusRepositoryInterface;
use Eds\Contractor\Persistence\Factory\StatusFactory;

class StatusUpdate
{
    private StatusRepositoryInterface $statusRepository;
    private StatusFactory $statusFactory;

    public function __construct(
        StatusRepositoryInterface $statusRepository,
        StatusFactory $statusFactory
    ) {
        $this->statusRepository = $statusRepository;
        $this->statusFactory = $statusFactory;
    }

    public function execute(UpdateRawDataInput $input): ContractorStatus
    {
        $data = $input->toArray();
        $contractorStatus = $this->statusRepository->findOne(new IdFilter($data['id']));

        if ($input->hasChanged($this->statusFactory->arrayToCreate($contractorStatus))) {
            $data['updatedAt'] = new DateTime();
            $contractorStatus->populateProps($data);
            $this->statusRepository->update($contractorStatus, array_keys($data));
        }

        return $contractorStatus;
    }
}
