<?php

namespace Nrg\Auth\Persistence\Abstraction;

use Nrg\Auth\Entity\User;
use Nrg\Data\Collection;

interface UserRepository
{
    public function findAll(object ...$dtoList): Collection;

    public function findOne(object ...$dtoList): User;

    public function create(User $user): void;

    public function update(User $user, array $fields = null): int;

    public function delete(object ...$dtoList): int;

    public function exists(object ...$dtoList): bool;
}
