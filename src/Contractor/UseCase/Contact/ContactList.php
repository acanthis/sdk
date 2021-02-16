<?php

namespace Eds\Contractor\UseCase\Contact;

use Eds\Contractor\Persistence\Abstraction\Repository\ContactRepositoryInterface;
use Nrg\Data\Collection;

class ContactList
{
    private ContactRepositoryInterface $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function execute(object ...$dtoList): Collection
    {
        return $this->contactRepository->findAll(...$dtoList);
    }
}
