<?php

namespace Eds\Contractor\UseCase\BankAccount;

use Eds\Contractor\Persistence\Abstraction\Repository\BankAccountRepositoryInterface;
use LogicException;
use Nrg\Data\Dto\Filtering;

class BankAccountDelete
{
    private BankAccountRepositoryInterface $bankAccountRepository;

    public function __construct(BankAccountRepositoryInterface $bankAccountRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
    }

    public function execute(array $data): int
    {
        $filter = (new Filtering($data))->getFilter();

        if ($filter->isEmpty()) {
            throw new LogicException('Filter cannot be empty');
        }

        return $this->bankAccountRepository->delete($filter);
    }
}
