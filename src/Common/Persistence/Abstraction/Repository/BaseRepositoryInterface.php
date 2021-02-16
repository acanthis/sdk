<?php

namespace Eds\Common\Persistence\Abstraction\Repository;

use Nrg\Data\Collection;
use Nrg\Data\Dto\Filter;

interface BaseRepositoryInterface
{
    public function delete(Filter $filter): int;

    public function findAll(object ...$dtoList): Collection;

    public function exists(Filter $filter): bool;
}