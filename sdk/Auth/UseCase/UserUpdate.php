<?php

namespace Nrg\Auth\UseCase;

use DateTime;
use Nrg\Auth\Dto\UserUpdateInput;
use Nrg\Auth\Entity\User;
use Nrg\Auth\Persistence\Abstraction\UserRepository;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;

class UserUpdate
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UserUpdateInput $updateInput): User
    {
        $user = $this->userRepository->findOne(
            (new Filter())
                ->addCondition(
                    (new EqualCondition())
                        ->setField('id')
                        ->setValue($updateInput->getId())
                )
        );

        if (!$updateInput->isEqual($user)) {
            $user
                ->setEmail($updateInput->getEmail())
                ->setUpdatedAt(new DateTime())
            ;

            $this->userRepository->update($user, ['email', 'updatedAt']);
        }

        return $user;
    }
}
