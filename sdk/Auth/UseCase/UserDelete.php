<?php

namespace Nrg\Auth\UseCase;

use LogicException;
use Nrg\Auth\Persistence\Abstraction\UserRepository;
use Nrg\Data\Dto\Filtering;

class UserDelete
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(array $data): int
    {
        $filter = (new Filtering($data))->getFilter();

        if ($filter->isEmpty()) {
            throw new LogicException('Filter cannot be empty');
        }

        return $this->userRepository->delete(
            (new Filtering($data))->getFilter()
        );
    }
}
