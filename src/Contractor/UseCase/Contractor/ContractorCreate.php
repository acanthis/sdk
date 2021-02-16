<?php

namespace Eds\Contractor\UseCase\Contractor;

use Eds\Contractor\Entity\Contractor;
use Eds\Contractor\Persistence\Abstraction\Repository\ContractorRepositoryInterface;
use Eds\Contractor\Persistence\Abstraction\Repository\CustomFieldValueRepositoryInterface;
use Eds\Contractor\Persistence\Factory\ContractorFactory;
use Eds\Contractor\Persistence\Factory\CustomFieldValueFactory;
use Nrg\Utility\Abstraction\UuidGenerator;

class ContractorCreate
{
    private ContractorRepositoryInterface $contractorRepository;
    private CustomFieldValueRepositoryInterface $customFieldValueRepository;
    private ContractorFactory $contractorFactory;
    private CustomFieldValueFactory $customFieldValueFactory;
    private UuidGenerator $uuidGenerator;

    public function __construct(
        ContractorRepositoryInterface $contractorRepository,
        CustomFieldValueRepositoryInterface $customFieldValueRepository,
        ContractorFactory $contractorFactory,
        CustomFieldValueFactory $customFieldValueFactory,
        UuidGenerator $uuidGenerator
    ) {
        $this->contractorRepository = $contractorRepository;
        $this->customFieldValueRepository = $customFieldValueRepository;
        $this->contractorFactory = $contractorFactory;
        $this->customFieldValueFactory = $customFieldValueFactory;
        $this->uuidGenerator = $uuidGenerator;
    }

    public function execute(array $data): Contractor
    {
        $data['id'] = $this->uuidGenerator->generateV4();
        $contractor = $this->contractorFactory->createEntity($data);
        $this->contractorRepository->create($contractor);

        foreach ($data as $customFieldId => $customFieldValue) {
            if ($this->uuidGenerator->isValidV4($customFieldId)) {
                $customFiledValueData = [
                    'id' => $this->uuidGenerator->generateV4(),
                    'customFieldId' => $customFieldId,
                    'contractorId' => $contractor->getId(),
                    'value' => $customFieldValue,
                ];
                $contractorCustomFieldValue = $this->customFieldValueFactory->createEntity($customFiledValueData);
                $this->customFieldValueRepository->create($contractorCustomFieldValue);
            }
        }

        return $contractor;
    }
}
