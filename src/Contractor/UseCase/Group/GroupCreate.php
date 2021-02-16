<?php

namespace Eds\Contractor\UseCase\Group;

use Eds\Contractor\Entity\ContractorGroup;
use Eds\Contractor\Persistence\Abstraction\Repository\GroupRepositoryInterface;
use Eds\Contractor\Persistence\Factory\GroupFactory;
use Nrg\Utility\Abstraction\UuidGenerator;

class GroupCreate
{
    private GroupRepositoryInterface $groupRepository;
    private GroupFactory $groupFactory;
    private UuidGenerator $uuid;

    public function __construct(
        GroupRepositoryInterface $groupRepository,
        GroupFactory $groupFactory,
        UuidGenerator $uuid
    ) {
        $this->groupRepository = $groupRepository;
        $this->groupFactory = $groupFactory;
        $this->uuid = $uuid;
    }

    public function execute(array $data): ContractorGroup
    {
        $data['id'] = $this->uuid->generateV4();

        $contractorGroup = $this->groupFactory->createEntity($data);
        $this->groupRepository->create($contractorGroup);

        return $contractorGroup;
    }
}
