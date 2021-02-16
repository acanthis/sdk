<?php

namespace Eds\Contractor\Persistence\Abstraction\Repository;

use Eds\Common\Persistence\Abstraction\Repository\BaseRepositoryInterface;
use Eds\Contractor\Entity\Contractor;

interface ContractorRepositoryInterface extends BaseRepositoryInterface
{
    public function create(Contractor $contractor): void;

    public function update(Contractor $contractor, array $fields = null): int;

    public function findOne(?object ...$dtoList): ?Contractor;
}
