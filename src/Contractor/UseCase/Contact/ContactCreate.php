<?php

namespace Eds\Contractor\UseCase\Contact;

use Eds\Contractor\Entity\ContractorContact;
use Eds\Contractor\Persistence\Abstraction\Repository\ContactRepositoryInterface;
use Eds\Contractor\Persistence\Abstraction\Repository\ContractorRepositoryInterface;
use Eds\Contractor\Persistence\Factory\ContactFactory;
use Nrg\Utility\Abstraction\UuidGenerator;

class ContactCreate
{
    private ContactRepositoryInterface $contactRepository;
    private ContractorRepositoryInterface $contractorRepository;
    private ContactFactory $contactFactory;
    private UuidGenerator $uuidGenerator;

    public function __construct(
        ContactRepositoryInterface $contactRepository,
        ContractorRepositoryInterface $contractorRepository,
        ContactFactory $contactFactory,
        UuidGenerator $uuid
    )
    {
        $this->contactRepository = $contactRepository;
        $this->contractorRepository = $contractorRepository;
        $this->contactFactory = $contactFactory;
        $this->uuidGenerator = $uuid;
    }

    public function execute(array $data): ContractorContact
    {
        $data['id'] = $this->uuidGenerator->generateV4();
        $contractorContact = $this->contactFactory->createEntity($data);

        if ($contractorContact->isDefault()) {
            $this->contactRepository->setAllDefault($contractorContact);
        }

        $this->contactRepository->create($contractorContact);

        return $contractorContact;
    }
}
