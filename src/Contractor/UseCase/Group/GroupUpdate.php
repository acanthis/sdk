<?php

namespace Eds\Contractor\UseCase\Group;

use DateTime;
use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Dto\UpdateRawDataInput;
use Eds\Contractor\Entity\ContractorGroup;
use Eds\Contractor\Persistence\Abstraction\Repository\GroupRepositoryInterface;
use Eds\Contractor\Persistence\Factory\GroupFactory;

class GroupUpdate
{
    private GroupRepositoryInterface $groupRepository;
    private GroupFactory $groupFactory;

    public function __construct(
        GroupRepositoryInterface $groupRepository,
        GroupFactory $groupFactory
    ) {
        $this->groupRepository = $groupRepository;
        $this->groupFactory = $groupFactory;
    }

    public function execute(UpdateRawDataInput $input): ContractorGroup
    {
        $data = $input->toArray();
        $contractorGroup = $this->groupRepository->findOne(new IdFilter($data['id']));

        if ($input->hasChanged($this->groupFactory->arrayToCreate($contractorGroup))) {
            $data['updatedAt'] = new DateTime();
            $contractorGroup->populateProps($data);
            $this->groupRepository->update($contractorGroup, array_keys($data));
        }

        return $contractorGroup;
    }
}
