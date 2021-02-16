<?php

namespace Eds\Contractor\UseCase\Contact;

use Eds\Contractor\Persistence\Abstraction\Repository\ContactRepositoryInterface;
use LogicException;
use Nrg\Data\Dto\Filtering;

class ContactDelete
{
    private ContactRepositoryInterface $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function execute(array $data): int
    {
        $filter = (new Filtering($data))->getFilter();

        if ($filter->isEmpty()) {
            throw new LogicException('Filter cannot be empty');
        }

        return $this->contactRepository->delete($filter);
    }
}
