<?php

namespace Eds\Contractor\Persistence\Abstraction\Repository;

use Eds\Common\Persistence\Abstraction\Repository\BaseRepositoryInterface;
use Eds\Contractor\Entity\ContractorBankAccount;

interface BankAccountRepositoryInterface extends BaseRepositoryInterface
{
    public function create(ContractorBankAccount $contractorBankAccount): void;

    public function update(ContractorBankAccount $contractorBankAccount, array $fields = null): int;

    public function setAllDefault(ContractorBankAccount $excludeBankAccount): int;

    public function findOne(?object ...$dtoList): ?ContractorBankAccount;
}
