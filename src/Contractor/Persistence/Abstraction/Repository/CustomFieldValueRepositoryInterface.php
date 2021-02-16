<?php

namespace Eds\Contractor\Persistence\Abstraction\Repository;

use Eds\Common\Persistence\Abstraction\Repository\BaseRepositoryInterface;
use Eds\Contractor\Entity\ContractorCustomFieldValue;
use Nrg\Data\Collection;

interface CustomFieldValueRepositoryInterface extends BaseRepositoryInterface
{
    public function create(ContractorCustomFieldValue $contractorCustomFieldValueValue): void;

    public function update(ContractorCustomFieldValue $contractorCustomFieldValue, array $fields = null): int;

    public function findOne(?object ...$dtoList): ?ContractorCustomFieldValue;
}
