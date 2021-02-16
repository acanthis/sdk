<?php

namespace Eds\Contractor\UseCase\CustomField;

use DateTime;
use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Entity\ContractorCustomField;
use Eds\Contractor\Persistence\Abstraction\Repository\CustomFieldRepositoryInterface;

class CustomFieldMarkAsDelete
{
    private CustomFieldRepositoryInterface $customFieldRepository;

    public function __construct(CustomFieldRepositoryInterface $customFieldRepository)
    {
        $this->customFieldRepository = $customFieldRepository;
    }

    public function execute(array $data): ContractorCustomField
    {
        $data['isMarkOnDelete'] = true;
        $data['updatedAt'] = new DateTime();

        $contractorCustomField = $this->customFieldRepository->findOne(new IdFilter($data['id']));
        $contractorCustomField->populateProps($data);
        $this->customFieldRepository->update($contractorCustomField, array_keys($data));

        return $contractorCustomField;
    }
}
