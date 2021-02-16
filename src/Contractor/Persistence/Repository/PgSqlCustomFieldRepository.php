<?php

namespace Eds\Contractor\Persistence\Repository;

use Eds\Contractor\Entity\ContractorCustomField;
use Eds\Contractor\Persistence\Abstraction\Repository\CustomFieldRepositoryInterface;
use Eds\Contractor\Persistence\Factory\CustomFieldFactory;
use Eds\Contractor\Persistence\Schema\PgSqlCustomFieldSchema;
use Nrg\Data\Collection;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Condition\InCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Data\Exception\EntityNotFoundException;

class PgSqlCustomFieldRepository implements CustomFieldRepositoryInterface
{
    private PgSqlCustomFieldSchema $customFieldSchema;
    private CustomFieldFactory $customFieldFactory;

    public function __construct(PgSqlCustomFieldSchema $customFieldSchema, CustomFieldFactory $customFieldFactory)
    {
        $this->customFieldSchema = $customFieldSchema;
        $this->customFieldFactory = $customFieldFactory;
    }

    public function findAll(object ...$dtoList): Collection
    {
        $iterator = $this->customFieldSchema->findAll(...$dtoList);
        $total = $this->customFieldSchema->count(...$dtoList);

        return $this->customFieldFactory
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

    public function create(ContractorCustomField $contractorCustomField): void
    {
        $this->customFieldSchema->insert(
            $this->customFieldFactory->arrayToCreate($contractorCustomField)
        );
    }

    public function update(ContractorCustomField $contractorCustomField, array $fields = null): int
    {
        $filter = (new Filter())
            ->addCondition(
                (new EqualCondition())
                    ->setValue($contractorCustomField->getId())
                    ->setField('id')
            )
        ;

        return $this->customFieldSchema->update(
            $this->customFieldFactory->arrayToUpdate($contractorCustomField, $fields),
            $filter
        );
    }

    public function delete(Filter $filter): int
    {
        return $this->customFieldSchema->delete($filter);
    }

    public function findOne(?object ...$dtoList):? ContractorCustomField
    {
        $contractorCustomField = $this->customFieldSchema->findOne(...$dtoList);

        if (null === $contractorCustomField) {
            throw new EntityNotFoundException('Contractor custom field was not found', 404);
        }

        return $this->customFieldFactory->createEntity($contractorCustomField);
    }

    public function exists(Filter $filter): bool
    {
        return $this->customFieldSchema->exists($filter);
    }
}
