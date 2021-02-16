<?php

namespace Nrg\Auth\Entity;

use DateTime;
use JsonSerializable;
use Nrg\Auth\Value\UserStatus;

class User implements JsonSerializable
{
    private string $id;

    private string $email;

    private string $password;

    private string $salt;

    private UserStatus $status;

    private DateTime $createdAt;

    private ?DateTime $updatedAt = null;

    public function __construct(
        string $id,
        string $email,
        string $password,
        string $salt,
        UserStatus $status,
        DateTime $createdAt
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->salt = $salt;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    public function setUpdatedAt(?DateTime $updatedAt): User
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function getStatus(): UserStatus
    {
        return $this->status;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function setStatus(UserStatus $status): User
    {
        $this->status = $status;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'status' => $this->getStatus()->getValue(),
            'createdAt' => $this->getCreatedAt()->format(DateTime::ISO8601),
            'updatedAt' => $this->getUpdatedAt() ?
                $this->getUpdatedAt()->format(DateTime::ISO8601) :
                null,
        ];
    }
}
