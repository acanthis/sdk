<?php

namespace Eds\Contractor\UseCase\Group;

use Eds\Contractor\Entity\ContractorGroup;
use Eds\Contractor\Persistence\Abstraction\Repository\GroupRepositoryInterface;
use LogicException;
use Nrg\Data\Dto\Filtering;

class GroupDelete
{
    private GroupRepositoryInterface $groupRepository;

    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function execute(array $data): int
    {
        $filter = (new Filtering($data))->getFilter();

        if ($filter->isEmpty()) {
            throw new LogicException('Filter cannot be empty');
        }

        return $this->groupRepository->delete($filter);
    }
}
