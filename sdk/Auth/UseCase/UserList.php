<?php

namespace Nrg\Auth\UseCase;

use Nrg\Auth\Persistence\Abstraction\UserRepository;
use Nrg\Data\Collection;

class UserList
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(object ...$dtoList): Collection
    {
        return $this->userRepository->findAll(...$dtoList);
    }
}
