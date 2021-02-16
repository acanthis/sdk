<?php

namespace Nrg\Auth\Dto;

class SignupInput
{
    private string $email;

    private string $password;

    public function __construct(array $data)
    {
        $this->email = $data['email'];
        $this->password = $data['password'];
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
