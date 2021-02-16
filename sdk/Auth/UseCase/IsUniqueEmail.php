<?php

namespace Nrg\Auth\UseCase;

use Nrg\Auth\Persistence\Abstraction\UserRepository;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;

class IsUniqueEmail
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $email): bool
    {
        return !$this->userRepository->exists(
            (new Filter())
                ->addCondition(
                    (new EqualCondition())
                        ->setField('email')
                        ->setValue($email)
                )
        );
    }
}
