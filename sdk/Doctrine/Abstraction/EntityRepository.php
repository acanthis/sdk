<?php

namespace Nrg\Doctrine\Abstraction;

use Nrg\Data\Collection;
use Nrg\Data\Dto\Filter;
use Nrg\Data\Dto\Metadata;

interface EntityRepository
{
    public function create(object $object): void;

    public function update(object $object, array $fields = null): int;

    public function delete(Filter $filter): int;

    public function findAll(Metadata $metadata): Collection;

    public function findOne(?object ...$dtoList): ?object;

    public function exists(Filter $filter): bool;
}
