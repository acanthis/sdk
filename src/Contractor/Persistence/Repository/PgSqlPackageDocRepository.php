<?php

namespace Eds\Contractor\Persistence\Repository;

use Eds\Contractor\Entity\ContractorPackageDoc;
use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocRepositoryInterface;
use Eds\Contractor\Persistence\Factory\PackageDocFactory;
use Eds\Contractor\Persistence\Schema\PgSqlPackageDocSchema;
use Nrg\Data\Collection;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Data\Exception\EntityNotFoundException;

class PgSqlPackageDocRepository implements PackageDocRepositoryInterface
{
    private PgSqlPackageDocSchema $packageDocSchema;
    private PackageDocFactory $packageDocFactory;

    public function __construct(PgSqlPackageDocSchema $packageDocSchema, PackageDocFactory $packageDocFactory)
    {
        $this->packageDocSchema = $packageDocSchema;
        $this->packageDocFactory = $packageDocFactory;
    }

    public function findAll(object ...$dtoList): Collection
    {
        $iterator = $this->packageDocSchema->findAll(...$dtoList);
        $total = $this->packageDocSchema->count(...$dtoList);

        return $this->packageDocFactory
            ->createCollection($iterator)
            ->setTotal($total)
        ;
    }

    public function create(ContractorPackageDoc $contractorPackageDoc): void
    {
        $this->packageDocSchema->insert(
            $this->packageDocFactory->arrayToCreate($contractorPackageDoc)
        );
    }

    public function update(ContractorPackageDoc $contractorPackageDoc, array $fields = null): int
    {
        $filter = (new Filter())
            ->addCondition(
                (new EqualCondition())
                    ->setValue($contractorPackageDoc->getId())
                    ->setField('id')
            )
        ;

        return $this->packageDocSchema->update(
            $this->packageDocFactory->arrayToUpdate($contractorPackageDoc, $fields),
            $filter
        );
    }

    public function delete(Filter $filter): int
    {
        return $this->packageDocSchema->delete($filter);
    }

    public function findOne(?object ...$dtoList):? ContractorPackageDoc
    {
        $contractorPackageDoc = $this->packageDocSchema->findOne(...$dtoList);

        if (null === $contractorPackageDoc) {
            throw new EntityNotFoundException('Contractor package doc was not found', 404);
        }

        return $this->packageDocFactory->createEntity($contractorPackageDoc);
    }

    public function exists(Filter $filter): bool
    {
        return $this->packageDocSchema->exists($filter);
    }
}
