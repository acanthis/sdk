<?php

namespace Eds\Contractor\UseCase\Status;

use Eds\Contractor\Entity\Contractor;
use Eds\Contractor\Persistence\Abstraction\Repository\ContractorRepositoryInterface;
use Eds\Contractor\Persistence\Abstraction\Repository\StatusRepositoryInterface;
use Nrg\Data\Condition\InCondition;
use Nrg\Data\Dto\Filter;

class StatusDelete
{
    private StatusRepositoryInterface $statusRepository;
    private ContractorRepositoryInterface $contractorRepository;

    public function __construct(StatusRepositoryInterface $statusRepository, ContractorRepositoryInterface $contractorRepository)
    {
        $this->statusRepository = $statusRepository;
        $this->contractorRepository = $contractorRepository;
    }

    public function execute(array $data): int
    {
        $contractorCollections = $this->contractorRepository->findAll((new Filter())
            ->addCondition(
                (new InCondition())
                    ->setField('statusId')
                    ->setList($data['statusIds'])
            )
        );

        /** @var Contractor $contractor */
        foreach ($contractorCollections->getData() as $contractor) {
            $contractor->setStatus(null);
            $this->contractorRepository->update($contractor, ['statusId']);
        }

        return $this->statusRepository->delete((new Filter())
            ->addCondition(
                (new InCondition())
                    ->setField('id')
                    ->setList($data['statusIds'])
            )
        );
    }
}
