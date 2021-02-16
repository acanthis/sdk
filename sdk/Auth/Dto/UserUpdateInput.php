<?php

namespace Nrg\Auth\Dto;

use Nrg\Auth\Entity\User;

class UserUpdateInput
{
    private string $id;

    private string $email;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->email = $data['email'];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isEqual(User $user): bool
    {
        return $this->email === $user->getEmail();
    }
}
