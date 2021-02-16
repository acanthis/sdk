<?php

namespace Nrg\Auth\Persistence\PgSql\Factory;

use DateTime;
use Iterator;
use Nrg\Auth\Entity\User;
use Nrg\Auth\Value\UserStatus;
use Nrg\Data\Collection;

class UserFactory
{
    public function toArray(User $user, array $fields = null): array
    {
        $user = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'status' => $user->getStatus()->getValue(),
            'salt' => $user->getSalt(),
            'createdAt' => $user->getCreatedAt()->format(DateTime::ISO8601),
            'updatedAt' => null === $user->getUpdatedAt() ?
                null :
                $user->getUpdatedAt()->format(DateTime::ISO8601),
        ];

        return null === $fields ? $user : array_filter(
            $user,
            function ($field) use (&$fields) {
                return in_array($field, $fields);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    public function createEntity(array $data): User
    {
        $user = new User(
            $data['id'],
            $data['email'],
            $data['password'],
            $data['salt'],
            new UserStatus($data['status']),
            new DateTime($data['createdAt'] ?? 'now')
        );

        if (isset($data['updatedAt'])) {
            $user->setUpdatedAt(new DateTime($data['updatedAt']));
        }

        return $user;
    }

    public function createCollection(Iterator $iterator): Collection
    {
        $collection = new Collection();

        foreach ($iterator as $data) {
            $collection->addEntity($this->createEntity($data));
        }

        return $collection;
    }
}
