<?php

namespace Eds\Contractor\Persistence\Repository;

use Eds\Common\Persistence\Filter\NotIdFilter;
use Eds\Contractor\Entity\ContractorContact;
use Eds\Contractor\Persistence\Abstraction\Repository\ContactRepositoryInterface;
use Eds\Contractor\Persistence\Factory\ContactFactory;
use Eds\Contractor\Persistence\Filter\ContractorIdFilter;
use Eds\Contractor\Persistence\Schema\PgSqlContactSchema;
use Nrg\Data\Collection;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Data\Exception\EntityNotFoundException;

class PgSqlContactRepository implements ContactRepositoryInterface
{
    private PgSqlContactSchema $contactSchema;
    private ContactFactory $contactFactory;

    public function __construct(PgSqlContactSchema $contactSchema, ContactFactory $contactFactory)
    {
        $this->contactSchema = $contactSchema;
        $this->contactFactory = $contactFactory;
    }

    public function setAllDefault(ContractorContact $excludeContact): int
    {
        $filter = (new ContractorIdFilter($excludeContact->getContractor()))
            ->addFilter(new NotIdFilter($excludeContact->getId()))
        ;

       return $this->contactSchema->update(['isDefault' => false], $filter);
    }

    public function findAll(object ...$dtoList): Collection
    {
        $iterator = $this->contactSchema->findAll(...$dtoList);
        $total = $this->contactSchema->count(...$dtoList);

        return $this->contactFactory
            ->createCollection($iterator)
            ->setTotal($total)
        ;
    }

    public function create(ContractorContact $contractorContact): void
    {
        $this->contactSchema->insert(
            $this->contactFactory->arrayToCreate($contractorContact)
        );
    }

    public function update(ContractorContact $contractorContact, array $fields = null): int
    {
        $filter = (new Filter())
            ->addCondition(
                (new EqualCondition())
                    ->setValue($contractorContact->getId())
                    ->setField('id')
            )
        ;

        return $this->contactSchema->update(
            $this->contactFactory->arrayToUpdate($contractorContact, $fields),
            $filter
        );
    }

    public function delete(Filter $filter): int
    {
        return $this->contactSchema->delete($filter);
    }

    public function findOne(?object ...$dtoList):? ContractorContact
    {
        $contractorContact = $this->contactSchema->findOne(...$dtoList);

        if (null === $contractorContact) {
            throw new EntityNotFoundException('Contractor contact was not found');
        }

        return $this->contactFactory->createEntity($contractorContact);
    }

    public function exists(Filter $filter): bool
    {
        return $this->contactSchema->exists($filter);
    }
}
