<?php

namespace Nrg\Auth\UseCase;

use Nrg\Auth\Entity\User;
use Nrg\Auth\Persistence\Abstraction\UserRepository;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;

class GetUserById
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $id): User
    {
        $user = $this->userRepository->findOne(
            (new Filter())
                ->addCondition(
                    (new EqualCondition())
                        ->setField('id')
                        ->setValue($id)
                )
        );

        return $user;
    }
}
