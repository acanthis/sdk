<?php

namespace Eds\Contractor\UseCase\Group;

use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Entity\ContractorGroup;
use Eds\Contractor\Persistence\Abstraction\Repository\GroupRepositoryInterface;

class GroupRead
{
    private GroupRepositoryInterface $groupRepository;

    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function execute(array $data): ContractorGroup
    {
        return $this->groupRepository->findOne(new IdFilter($data['id']));
    }
}
