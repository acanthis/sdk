<?php

namespace Eds\Contractor\UseCase\CustomField;

use DateTime;
use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Dto\UpdateRawDataInput;
use Eds\Contractor\Entity\ContractorCustomField;
use Eds\Contractor\Persistence\Abstraction\Repository\CustomFieldRepositoryInterface;
use Eds\Contractor\Persistence\Factory\CustomFieldFactory;

class CustomFieldUpdate
{
    private CustomFieldRepositoryInterface $customFieldRepository;
    private CustomFieldFactory $customFieldFactory;

    public function __construct(
        CustomFieldRepositoryInterface $customFieldRepository,
        CustomFieldFactory $customFieldFactory
    ) {
        $this->customFieldRepository = $customFieldRepository;
        $this->customFieldFactory = $customFieldFactory;
    }

    public function execute(UpdateRawDataInput $input): ContractorCustomField
    {
        $data = $input->toArray();
        $contractorCustomField = $this->customFieldRepository->findOne(new IdFilter($data['id']));

        if ($input->hasChanged($this->customFieldFactory->arrayToCreate($contractorCustomField))) {
            $data['updatedAt'] = new DateTime();
            $contractorCustomField->populateProps($data);
            $this->customFieldRepository->update($contractorCustomField, array_keys($data));
        }

        return $contractorCustomField;
    }
}
