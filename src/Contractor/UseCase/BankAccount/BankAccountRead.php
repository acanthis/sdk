<?php

namespace Eds\Contractor\UseCase\BankAccount;

use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Entity\ContractorBankAccount;
use Eds\Contractor\Persistence\Abstraction\Repository\BankAccountRepositoryInterface;

class BankAccountRead
{
    private BankAccountRepositoryInterface $bankAccountRepository;

    public function __construct(BankAccountRepositoryInterface $bankAccountRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
    }

    public function execute(array $data): ContractorBankAccount
    {
        return $this->bankAccountRepository->findOne(new IdFilter($data['id']));
    }
}
