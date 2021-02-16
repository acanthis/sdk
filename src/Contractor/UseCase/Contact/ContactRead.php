<?php

namespace Eds\Contractor\UseCase\Contact;

use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Entity\ContractorContact;
use Eds\Contractor\Persistence\Abstraction\Repository\ContactRepositoryInterface;

class ContactRead
{
    private ContactRepositoryInterface $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function execute(array $data): ContractorContact
    {
        return $this->contactRepository->findOne(new IdFilter($data['id']));
    }
}
