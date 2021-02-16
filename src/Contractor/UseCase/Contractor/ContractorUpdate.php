<?php

namespace Eds\Contractor\UseCase\Contractor;

use DateTime;
use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Dto\ContractorUpdateRawDataInput;
use Eds\Contractor\Entity\Contractor;
use Eds\Contractor\Entity\ContractorCustomFieldValue;
use Eds\Contractor\Persistence\Abstraction\Repository\ContractorRepositoryInterface;
use Eds\Contractor\Persistence\Abstraction\Repository\CustomFieldValueRepositoryInterface;
use Eds\Contractor\Persistence\Factory\ContractorFactory;
use Eds\Contractor\Persistence\Factory\CustomFieldValueFactory;
use Eds\Contractor\Value\ContractorType;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Condition\InCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Utility\Abstraction\UuidGenerator;

class ContractorUpdate
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


    public function execute(ContractorUpdateRawDataInput $input): Contractor
    {
        $contractorData = $input->dataToArray();
        $contractor = $this->contractorRepository->findOne(new IdFilter($contractorData['id']));
        $hasChanged = false;

        /** @var ContractorCustomFieldValue[] $contractorCustomFieldValues */
        $contractorCustomFieldValues = $this->customFieldValueRepository->findAll((new Filter())
            ->addCondition((new InCondition())
                ->setList(array_keys($input->customFieldDataToArray()))
                ->setField('customFieldId')
            )
            ->addCondition((new EqualCondition())
                ->setValue($contractor->getId())
                ->setField('contractorId')
            )
        );

        foreach ($contractorCustomFieldValues as $contractorCustomFieldValue) {
            foreach ($input->customFieldDataToArray() as $customFieldDataId => $customFieldDataValue) {
                if ($contractorCustomFieldValue->getCustomField() === $customFieldDataId && $contractorCustomFieldValue->getValue() != $customFieldDataValue) {
                    $hasChanged ?: $hasChanged = true;
                    $contractorCustomFieldValue->setValue($customFieldDataValue);
                    $this->customFieldValueRepository->update($contractorCustomFieldValue);

                    break;
                }
            }
        }

        if ($input->hasChanged($this->contractorFactory->arrayToCreate($contractor))) {
            $hasChanged ?: $hasChanged = true;
            $this->cleaningUnnecessaryFields($contractorData);

            if (isset($contractorData['dateOfCertificate'])) {
                $contractorData['dateOfCertificate'] = new DateTime($contractorData['dateOfCertificate']);
            }
        }

        if ($hasChanged) {
            $contractorData['updatedAt'] = new DateTime();
            $contractor->populateProps($contractorData);
            $this->contractorRepository->update($contractor, array_keys($contractorData));
        }

        return $contractor;
    }

    private function cleaningUnnecessaryFields(array &$data): void
    {
        if (isset($data['type'])) {
            switch ($data['type']) {
                case ContractorType::CONTRACTOR_TYPE_SP:
                    $data['kpp'] = null;
                    $data['ogrn'] = null;
                    $data['legalAddress'] = null;
                    $data['registrationAddress'] = null;

                    break;
                case ContractorType::CONTRACTOR_TYPE_EN:
                    $data['ogrnIp'] = null;
                    $data['numberOfCertificate'] = null;
                    $data['dateOfCertificate'] = null;
                    $data['registrationAddress'] = null;

                    break;
                case ContractorType::CONTRACTOR_TYPE_PE:
                    $data['kpp'] = null;
                    $data['okpo'] = null;
                    $data['ogrn'] = null;
                    $data['ogrnIp'] = null;
                    $data['legalAddress'] = null;
                    $data['dateOfCertificate'] = null;
                    $data['numberOfCertificate'] = null;

                    break;
            }

            $data['type'] = new ContractorType($data['type']);
        }
    }
}
