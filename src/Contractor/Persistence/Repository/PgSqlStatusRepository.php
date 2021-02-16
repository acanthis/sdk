<?php

namespace Eds\Contractor\Persistence\Repository;

use Eds\Contractor\Entity\ContractorStatus;
use Eds\Contractor\Persistence\Abstraction\Repository\StatusRepositoryInterface;
use Eds\Contractor\Persistence\Factory\StatusFactory;
use Eds\Contractor\Persistence\Schema\PgSqlStatusSchema;
use Nrg\Data\Collection;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Data\Exception\EntityNotFoundException;

class PgSqlStatusRepository implements StatusRepositoryInterface
{
    private PgSqlStatusSchema $statusSchema;
    private StatusFactory $statusFactory;

    public function __construct(PgSqlStatusSchema $statusSchema, StatusFactory $statusFactory)
    {
        $this->statusSchema = $statusSchema;
        $this->statusFactory = $statusFactory;
    }

    public function findAll(object ...$dtoList): Collection
    {
        $iterator = $this->statusSchema->findAll(...$dtoList);
        $total = $this->statusSchema->count(...$dtoList);

        return $this->statusFactory
            ->createCollection($iterator)
            ->setTotal($total)
        ;
    }

    public function create(ContractorStatus $contractorStatus): void
    {
        $this->statusSchema->insert(
            $this->statusFactory->arrayToCreate($contractorStatus)
        );
    }

    public function update(ContractorStatus $contractorStatus, array $fields = null): int
    {
        $filter = (new Filter())
            ->addCondition(
                (new EqualCondition())
                    ->setValue($contractorStatus->getId())
                    ->setField('id')
            )
        ;

        return $this->statusSchema->update(
            $this->statusFactory->arrayToUpdate($contractorStatus, $fields),
            $filter
        );
    }

    public function delete(Filter $filter): int
    {
        return $this->statusSchema->delete($filter);
    }

    public function findOne(?object ...$dtoList): ?ContractorStatus
    {
        $contractorStatus = $this->statusSchema->findOne(...$dtoList);

        if (null === $contractorStatus) {
            throw new EntityNotFoundException('Contractor status was not found');
        }

        return $this->statusFactory->createEntity($contractorStatus);
    }

    public function exists(Filter $filter): bool
    {
        return $this->statusSchema->exists($filter);
    }
}
