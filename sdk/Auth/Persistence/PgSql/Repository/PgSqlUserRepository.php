<?php

namespace Nrg\Auth\Persistence\PgSql\Repository;

use Nrg\Auth\Entity\User;
use Nrg\Auth\Persistence\Abstraction\UserRepository;
use Nrg\Auth\Persistence\PgSql\Factory\UserFactory;
use Nrg\Auth\Persistence\PgSql\Schema\PgSqlUserSchema;
use Nrg\Data\Collection;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Data\Exception\EntityNotFoundException;

class PgSqlUserRepository implements UserRepository
{
    private PgSqlUserSchema $userSchema;
    private UserFactory $userFactory;

    public function __construct(PgSqlUserSchema $userSchema, UserFactory $userFactory)
    {
        $this->userSchema = $userSchema;
        $this->userFactory = $userFactory;
    }

    public function findAll(object ...$dtoList): Collection
    {
        $iterator = $this->userSchema->findAll(...$dtoList);
        $total = $this->userSchema->count(...$dtoList);

        return $this->userFactory
            ->createCollection($iterator)
            ->setTotal($total)
        ;
    }

    public function findOne(object ...$dtoList): User
    {
        $user = $this->userSchema->findOne(...$dtoList);

        if (null === $user) {
            throw new EntityNotFoundException('User was not found');
        }

        return $this->userFactory->createEntity($user);
    }

    public function create(User $user): void
    {
        $this->userSchema->insert(
            $this->userFactory->toArray($user)
        );
    }

    public function update(User $user, array $fields = null): int
    {
        $filter = (new Filter())
            ->addCondition(
                (new EqualCondition())
                    ->setValue($user->getId())
                    ->setField('id')
            )
        ;

        return $this->userSchema->update(
            $this->userFactory->toArray($user, $fields),
            $filter
        );
    }

    public function delete(object ...$dtoList): int
    {
        return $this->userSchema->delete(...$dtoList);
    }

    public function exists(object ...$dtoList): bool
    {
        return $this->userSchema->exists(...$dtoList);
    }
}
