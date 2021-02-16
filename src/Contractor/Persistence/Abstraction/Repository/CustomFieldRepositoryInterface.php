<?php

namespace Eds\Contractor\Persistence\Abstraction\Repository;

use Eds\Common\Persistence\Abstraction\Repository\BaseRepositoryInterface;
use Eds\Contractor\Entity\ContractorCustomField;
use Nrg\Data\Collection;

interface CustomFieldRepositoryInterface extends BaseRepositoryInterface
{
    public function create(ContractorCustomField $contractorCustomField): void;

    public function update(ContractorCustomField $contractorCustomField, array $fields = null): int;

    public function findOne(?object ...$dtoList): ?ContractorCustomField;

    public function findAllByIds(array $customFieldIds): Collection;
}
