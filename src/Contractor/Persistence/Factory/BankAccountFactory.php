<?php

namespace Eds\Contractor\Persistence\Factory;

use DateTime;
use Eds\Contractor\Entity\ContractorBankAccount;
use Iterator;
use Nrg\Data\Collection;

class BankAccountFactory
{
    public function arrayToCreate(ContractorBankAccount $contractorBankAccount): array
    {
        return [
            'id' => $contractorBankAccount->getId(),
            'contractorId' => $contractorBankAccount->getContractor(),
            'creatorId' => $contractorBankAccount->getCreator(),
            'checkingAccount' => $contractorBankAccount->getCheckingAccount(),
            'bankIdentificationCode' => $contractorBankAccount->getBankIdentificationCode(),
            'correspondentAccount' => $contractorBankAccount->getCorrespondentAccount(),
            'bankName' => $contractorBankAccount->getBankName(),
            'bankAddress' => $contractorBankAccount->getBankAddress(),
            'note' => $contractorBankAccount->getNote(),
            'isDefault' => $contractorBankAccount->isDefault() ? 1 : 0,
            'createdAt' => $contractorBankAccount->getCreatedAt()->format('Y-m-d h:i:s'),
            'updatedAt' => (null === $contractorBankAccount->getUpdatedAt()) ? null : $contractorBankAccount->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }

    public function arrayToUpdate(ContractorBankAccount $contractorBankAccount, array $fields = null): array
    {
        $contractorContactArray = $this->arrayToCreate($contractorBankAccount);

        unset($contractorContactArray['id']);

        return null === $fields ? $contractorContactArray : array_filter(
            $contractorContactArray,
            function ($field) use (&$fields) {
                return in_array($field, $fields);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    public function createEntity(array $data): ContractorBankAccount
    {
        $data['createdAt'] = new DateTime($data['createdAt'] ?? 'now');

        if (isset($data['updatedAt'])) {
            $data['updatedAt'] = new DateTime($data['updatedAt']);
        }

        $contractorBankAccount = new ContractorBankAccount(
            $data['id'],
            $data['contractorId'],
            $data['creatorId'],
            $data['checkingAccount'],
            $data['isDefault'],
            $data['createdAt']
        );

        $contractorBankAccount->populateProps($data);

        return $contractorBankAccount;
    }

    public function createCollection(Iterator $iterator): Collection
    {
        $collection = new Collection();

        foreach ($iterator as $data) {
            $collection->addEntity($this->createEntity($data));
        }

        return $collection;
    }
}
