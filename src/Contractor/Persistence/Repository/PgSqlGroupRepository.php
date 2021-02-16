<?php

namespace Eds\Contractor\Persistence\Repository;

use Eds\Contractor\Entity\ContractorGroup;
use Eds\Contractor\Persistence\Abstraction\Repository\GroupRepositoryInterface;
use Eds\Contractor\Persistence\Factory\GroupFactory;
use Eds\Contractor\Persistence\Schema\PgSqlGroupSchema;
use Nrg\Data\Collection;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Data\Exception\EntityNotFoundException;

class PgSqlGroupRepository implements GroupRepositoryInterface
{
    private PgSqlGroupSchema $groupSchema;
    private GroupFactory $groupFactory;

    public function __construct(PgSqlGroupSchema $groupSchema, GroupFactory $groupFactory)
    {
        $this->groupSchema = $groupSchema;
        $this->groupFactory = $groupFactory;
    }

    public function findAll(object ...$dtoList): Collection
    {
        $iterator = $this->groupSchema->findAll(...$dtoList);
        $total = $this->groupSchema->count(...$dtoList);

        return $this->groupFactory
            ->createCollection($iterator)
            ->setTotal($total)
        ;
    }

    public function create(ContractorGroup $contractorGroup): void
    {
        $this->groupSchema->insert(
            $this->groupFactory->arrayToCreate($contractorGroup)
        );
    }

    public function update(ContractorGroup $contractorGroup, array $fields = null): int
    {
        $filter = (new Filter())
            ->addCondition(
                (new EqualCondition())
                    ->setValue($contractorGroup->getId())
                    ->setField('id')
            )
        ;

        return $this->groupSchema->update(
            $this->groupFactory->arrayToUpdate($contractorGroup, $fields),
            $filter
        );
    }

    public function delete(Filter $filter): int
    {
        return $this->groupSchema->delete($filter);
    }

    public function findOne(?object ...$dtoList): ?ContractorGroup
    {
        $contractorGroup = $this->groupSchema->findOne(...$dtoList);

        if (null === $contractorGroup) {
            throw new EntityNotFoundException('Contractor group was not found');
        }

        return $this->groupFactory->createEntity($contractorGroup);
    }

    public function exists(Filter $filter): bool
    {
        return $this->groupSchema->exists($filter);
    }
}
