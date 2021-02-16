<?php

namespace Eds\Contractor\Persistence\Repository;

use Eds\Common\Persistence\Filter\NotIdFilter;
use Eds\Contractor\Entity\ContractorBankAccount;
use Eds\Contractor\Persistence\Abstraction\Repository\BankAccountRepositoryInterface;
use Eds\Contractor\Persistence\Factory\BankAccountFactory;
use Eds\Contractor\Persistence\Filter\ContractorIdFilter;
use Eds\Contractor\Persistence\Schema\PgSqlBankAccountSchema;
use Nrg\Data\Collection;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Data\Exception\EntityNotFoundException;

class PgSqlBankAccountRepository implements BankAccountRepositoryInterface
{
    private PgSqlBankAccountSchema $bankAccountSchema;
    private BankAccountFactory $bankAccountFactory;

    public function __construct(PgSqlBankAccountSchema $bankAccountSchema, BankAccountFactory $bankAccountFactory)
    {
        $this->bankAccountSchema = $bankAccountSchema;
        $this->bankAccountFactory = $bankAccountFactory;
    }

    public function setAllDefault(ContractorBankAccount $excludeBankAccount): int
    {
        $filter = (new ContractorIdFilter($excludeBankAccount->getContractor()))
            ->addFilter(new NotIdFilter($excludeBankAccount->getId()))
        ;

       return $this->bankAccountSchema->update(['isDefault' => false], $filter);
    }

    public function findAll(object ...$dtoList): Collection
    {
        $iterator = $this->bankAccountSchema->findAll(...$dtoList);
        $total = $this->bankAccountSchema->count(...$dtoList);

        return $this->bankAccountFactory
            ->createCollection($iterator)
            ->setTotal($total)
        ;
    }

    public function create(ContractorBankAccount $excludeBankAccount): void
    {
        $this->bankAccountSchema->insert(
            $this->bankAccountFactory->arrayToCreate($excludeBankAccount)
        );
    }

    public function update(ContractorBankAccount $excludeBankAccount, array $fields = null): int
    {
        $filter = (new Filter())
            ->addCondition(
                (new EqualCondition())
                    ->setValue($excludeBankAccount->getId())
                    ->setField('id')
            )
        ;

        return $this->bankAccountSchema->update(
            $this->bankAccountFactory->arrayToUpdate($excludeBankAccount, $fields),
            $filter
        );
    }

    public function delete(Filter $filter): int
    {
        return $this->bankAccountSchema->delete($filter);
    }

    public function findOne(?object ...$dtoList):? ContractorBankAccount
    {
        $contractorBankAccount = $this->bankAccountSchema->findOne(...$dtoList);

        if (null === $contractorBankAccount) {
            throw new EntityNotFoundException('Contractor bank account was not found');
        }

        return $this->bankAccountFactory->createEntity($contractorBankAccount);
    }

    public function exists(Filter $filter): bool
    {
        return $this->bankAccountSchema->exists($filter);
    }
}
