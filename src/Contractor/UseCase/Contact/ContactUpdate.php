<?php

namespace Eds\Contractor\UseCase\Contact;

use DateTime;
use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Dto\UpdateRawDataInput;
use Eds\Contractor\Entity\ContractorContact;
use Eds\Contractor\Persistence\Abstraction\Repository\ContactRepositoryInterface;
use Eds\Contractor\Persistence\Factory\ContactFactory;

class ContactUpdate
{
    private ContactRepositoryInterface $contactRepository;
    private ContactFactory $contactFactory;

    public function __construct(
        ContactRepositoryInterface $contactRepository,
        ContactFactory $contactFactory
    ) {
        $this->contactRepository = $contactRepository;
        $this->contactFactory = $contactFactory;
    }

    public function execute(UpdateRawDataInput $input): ContractorContact
    {
        $data = $input->toArray();
        $contractorContact = $this->contactRepository->findOne(new IdFilter($data['id']));

        if ($input->hasChanged($this->contactFactory->arrayToCreate($contractorContact))) {
            if (isset($data['isDefault']) && $data['isDefault'] && $data['isDefault'] !== $contractorContact->isDefault()) {
                $this->contactRepository->setAllDefault($contractorContact);
            }

            $data['updatedAt'] = new DateTime();
            $contractorContact->populateProps($data);
            $this->contactRepository->update($contractorContact, array_keys($data));
        }

        return $contractorContact;
    }
}
