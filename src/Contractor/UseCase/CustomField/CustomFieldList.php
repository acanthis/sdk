<?php

namespace Eds\Contractor\UseCase\CustomField;

use Eds\Contractor\Persistence\Abstraction\Repository\CustomFieldRepositoryInterface;
use Nrg\Data\Collection;

class CustomFieldList
{
    private CustomFieldRepositoryInterface $customFieldRepository;

    public function __construct(CustomFieldRepositoryInterface $customFieldRepository)
    {
        $this->customFieldRepository = $customFieldRepository;
    }

    public function execute(object ...$dtoList): Collection
    {
        return $this->customFieldRepository->findAll(...$dtoList);
    }
}
