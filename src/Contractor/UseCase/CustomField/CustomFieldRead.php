<?php

namespace Eds\Contractor\UseCase\CustomField;

use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Entity\ContractorCustomField;
use Eds\Contractor\Persistence\Abstraction\Repository\CustomFieldRepositoryInterface;

class CustomFieldRead
{
    private CustomFieldRepositoryInterface $customFieldRepository;

    public function __construct(CustomFieldRepositoryInterface $customFieldRepository)
    {
        $this->customFieldRepository = $customFieldRepository;
    }

    public function execute(array $data): ContractorCustomField
    {
        return $this->customFieldRepository->findOne(new IdFilter($data['id']));
    }
}
