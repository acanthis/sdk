<?php

namespace Eds\Contractor\Persistence\Repository;

use Eds\Contractor\Entity\ContractorCustomFieldValue;
use Eds\Contractor\Persistence\Abstraction\Repository\CustomFieldValueRepositoryInterface;
use Eds\Contractor\Persistence\Factory\CustomFieldValueFactory;
use Eds\Contractor\Persistence\Schema\PgSqlCustomFieldValueSchema;
use Nrg\Data\Collection;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Condition\InCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Data\Exception\EntityNotFoundException;

class PgSqlCustomFieldValueRepository implements CustomFieldValueRepositoryInterface
{
    private PgSqlCustomFieldValueSchema $customFieldValueSchema;
    private CustomFieldValueFactory $customFieldValueFactory;

    public function __construct(PgSqlCustomFieldValueSchema $customFieldValueSchema, CustomFieldValueFactory $customFieldValueFactory)
    {
        $this->customFieldValueSchema = $customFieldValueSchema;
        $this->customFieldValueFactory = $customFieldValueFactory;
    }

    public function findAll(object ...$dtoList): Collection
    {
        $iterator = $this->customFieldValueSchema->findAll(...$dtoList);
        $total = $this->customFieldValueSchema->count(...$dtoList);

        return $this->customFieldValueFactory
            ->createCollection($iterator)
            ->setTotal($total)
        ;
    }

    public function findAllByIds(array $customFieldIds): Collection
    {
        return $this->findAll(
            (new Filter())
                ->addCondition(
                    (new InCondition())
                        ->setList($customFieldIds)
                        ->setField('id')
                )
        );
    }

    public function create(ContractorCustomFieldValue $contractorCustomFieldValue): void
    {
        $this->customFieldValueSchema->insert(
            $this->customFieldValueFactory->arrayToCreate($contractorCustomFieldValue)
        );
    }

    public function update(ContractorCustomFieldValue $contractorCustomFieldValue, array $fields = null): int
    {
        $filter = (new Filter())
            ->addCondition(
                (new EqualCondition())
                    ->setValue($contractorCustomFieldValue->getId())
                    ->setField('id')
            )
        ;

        return $this->customFieldValueSchema->update(
            $this->customFieldValueFactory->arrayToUpdate($contractorCustomFieldValue, $fields),
            $filter
        );
    }

    public function delete(Filter $filter): int
    {
        return $this->customFieldValueSchema->delete($filter);
    }

    public function findOne(?object ...$dtoList):? ContractorCustomFieldValue
    {
        $contractorCustomFieldValue = $this->customFieldValueSchema->findOne(...$dtoList);

        if (null === $contractorCustomFieldValue) {
            throw new EntityNotFoundException('Contractor custom field value was not found', 404);
        }

        return $this->customFieldValueFactory->createEntity($contractorCustomFieldValue);
    }

    public function exists(Filter $filter): bool
    {
        return $this->customFieldValueSchema->exists($filter);
    }
}
