<?php

namespace Eds\Contractor\UseCase\BankAccount;

use Eds\Contractor\Persistence\Abstraction\Repository\BankAccountRepositoryInterface;
use Nrg\Data\Collection;

class BankAccountList
{
    private BankAccountRepositoryInterface $bankAccountRepository;

    public function __construct(BankAccountRepositoryInterface $contractorBankAccountRepository)
    {
        $this->bankAccountRepository = $contractorBankAccountRepository;
    }

    public function execute(object ...$dtoList): Collection
    {
        return $this->bankAccountRepository->findAll(...$dtoList);
    }
}
