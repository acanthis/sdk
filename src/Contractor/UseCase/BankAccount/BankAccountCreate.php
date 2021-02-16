<?php

namespace Eds\Contractor\UseCase\BankAccount;

use Eds\Contractor\Entity\ContractorBankAccount;
use Eds\Contractor\Persistence\Abstraction\Repository\BankAccountRepositoryInterface;
use Eds\Contractor\Persistence\Abstraction\Repository\ContractorRepositoryInterface;
use Eds\Contractor\Persistence\Factory\BankAccountFactory;
use Nrg\Utility\Abstraction\UuidGenerator;

class BankAccountCreate
{
    private BankAccountRepositoryInterface $bankAccountRepository;
    private ContractorRepositoryInterface $contractorRepository;
    private BankAccountFactory $bankAccountFactory;
    private UuidGenerator $uuidGenerator;

    public function __construct(
        BankAccountRepositoryInterface $bankAccountRepository,
        ContractorRepositoryInterface $contractorRepository,
        BankAccountFactory $bankAccountFactory,
        UuidGenerator $uuid
    )
    {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->contractorRepository = $contractorRepository;
        $this->bankAccountFactory = $bankAccountFactory;
        $this->uuidGenerator = $uuid;
    }

    public function execute(array $data): ContractorBankAccount
    {
        $data['id'] = $this->uuidGenerator->generateV4();
        $contractorBankAccount = $this->bankAccountFactory->createEntity($data);

        if ($contractorBankAccount->isDefault()) {
            $this->bankAccountRepository->setAllDefault($contractorBankAccount);
        }

        $this->bankAccountRepository->create($contractorBankAccount);

        return $contractorBankAccount;
    }
}
