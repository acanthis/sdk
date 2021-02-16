<?php

namespace Eds\Contractor\UseCase\BankAccount;

use DateTime;
use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Dto\UpdateRawDataInput;
use Eds\Contractor\Entity\ContractorBankAccount;
use Eds\Contractor\Persistence\Abstraction\Repository\BankAccountRepositoryInterface;
use Eds\Contractor\Persistence\Factory\BankAccountFactory;

class BankAccountUpdate
{
    private BankAccountRepositoryInterface $bankAccountRepository;
    private BankAccountFactory $bankAccountFactory;

    public function __construct(
        BankAccountRepositoryInterface $bankAccountRepository,
        BankAccountFactory $bankAccountFactory
    ) {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->bankAccountFactory = $bankAccountFactory;
    }

    public function execute(UpdateRawDataInput $input): ContractorBankAccount
    {
        $data = $input->toArray();
        $contractorBankAccount = $this->bankAccountRepository->findOne(new IdFilter($data['id']));

        if ($input->hasChanged($this->bankAccountFactory->arrayToCreate($contractorBankAccount))) {
            if (isset($data['isDefault']) && $data['isDefault'] && $data['isDefault'] !== $contractorBankAccount->isDefault()) {
                $this->bankAccountRepository->setAllDefault($contractorBankAccount);
            }

            $data['updatedAt'] = new DateTime();
            $contractorBankAccount->populateProps($data);
            $this->bankAccountRepository->update($contractorBankAccount, array_keys($data));
        }

        return $contractorBankAccount;
    }
}
