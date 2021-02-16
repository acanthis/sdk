<?php

namespace Eds\Contractor\UseCase\Group;

use Eds\Contractor\Persistence\Abstraction\Repository\GroupRepositoryInterface;
use Nrg\Data\Collection;

class GroupList
{
    private GroupRepositoryInterface $groupRepository;

    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function execute(object ...$dtoList): Collection
    {
        return $this->groupRepository->findAll(...$dtoList);
    }
}
