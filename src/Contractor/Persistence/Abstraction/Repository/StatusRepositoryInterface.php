<?php

namespace Eds\Contractor\Persistence\Abstraction\Repository;

use Eds\Common\Persistence\Abstraction\Repository\BaseRepositoryInterface;
use Eds\Contractor\Entity\ContractorStatus;

interface StatusRepositoryInterface extends BaseRepositoryInterface
{
    public function create(ContractorStatus $contractorStatus): void;

    public function update(ContractorStatus $contractorStatus, array $fields = null): int;

    public function findOne(?object ...$dtoList): ?ContractorStatus;
}
