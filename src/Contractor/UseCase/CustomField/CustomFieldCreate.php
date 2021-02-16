<?php

namespace Eds\Contractor\UseCase\CustomField;

use Eds\Contractor\Entity\ContractorCustomField;
use Eds\Contractor\Persistence\Abstraction\Repository\CustomFieldRepositoryInterface;
use Eds\Contractor\Persistence\Factory\CustomFieldFactory;
use Eds\CustomFields\Dto\CustomFieldCreateInput;
use Nrg\Utility\Abstraction\UuidGenerator;

class CustomFieldCreate
{
    private CustomFieldRepositoryInterface $customFieldRepository;
    private CustomFieldFactory $customFieldFactory;
    private UuidGenerator $uuidGenerator;

    public function __construct(
        CustomFieldRepositoryInterface $customFieldRepository,
        CustomFieldFactory $customFieldFactory,
        UuidGenerator $uuid
    )
    {
        $this->customFieldRepository = $customFieldRepository;
        $this->customFieldFactory = $customFieldFactory;
        $this->uuidGenerator = $uuid;
    }

    public function execute(CustomFieldCreateInput $input): array
    {
        $contractorCustomFields = [];

        foreach ($input->getCustomFields() as $customField) {
            $customFieldData = $customField->toArray();
            $customFieldData['id'] = $this->uuidGenerator->generateV4();
            $contractorCustomField = $this->customFieldFactory->createEntity($customFieldData);
            $this->customFieldRepository->create($contractorCustomField);
            $contractorCustomFields[] = $contractorCustomField;
        }

        return $contractorCustomFields;
    }
}
