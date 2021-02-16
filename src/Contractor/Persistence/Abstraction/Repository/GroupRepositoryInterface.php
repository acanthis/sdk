<?php

namespace Eds\Contractor\Persistence\Abstraction\Repository;

use Eds\Common\Persistence\Abstraction\Repository\BaseRepositoryInterface;
use Eds\Contractor\Entity\ContractorGroup;

interface GroupRepositoryInterface extends BaseRepositoryInterface
{
    public function create(ContractorGroup $contractorStatus): void;

    public function update(ContractorGroup $contractorStatus, array $fields = null): int;

    public function findOne(?object ...$dtoList): ?ContractorGroup;
}
