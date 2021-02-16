<?php

namespace Eds\Contractor\Persistence\Repository;

use Eds\Contractor\Entity\ContractorPackageDocFile;
use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocFileRepositoryInterface;
use Eds\Contractor\Persistence\Factory\PackageDocFileFactory;
use Eds\Contractor\Persistence\Schema\PgSqlPackageDocFileSchema;
use Nrg\Data\Collection;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Data\Exception\EntityNotFoundException;

class PgSqlPackageDocFileRepository implements PackageDocFileRepositoryInterface
{
    private PgSqlPackageDocFileSchema $packageDocFileSchema;
    private PackageDocFileFactory $packageDocFileFactory;

    public function __construct(PgSqlPackageDocFileSchema $packageDocFileSchema, PackageDocFileFactory $packageDocFileFactory)
    {
        $this->packageDocFileSchema = $packageDocFileSchema;
        $this->packageDocFileFactory = $packageDocFileFactory;
    }

    public function findAll(object ...$dtoList): Collection
    {
        $iterator = $this->packageDocFileSchema->findAll(...$dtoList);
        $total = $this->packageDocFileSchema->count(...$dtoList);

        return $this->packageDocFileFactory
            ->createCollection($iterator)
            ->setTotal($total)
        ;
    }

    public function create(ContractorPackageDocFile $packageDocFile): void
    {
        $this->packageDocFileSchema->insert(
            $this->packageDocFileFactory->arrayToCreate($packageDocFile)
        );
    }

    public function update(ContractorPackageDocFile $packageDocFile, array $fields = null): int
    {
        $filter = (new Filter())
            ->addCondition(
                (new EqualCondition())
                    ->setValue($packageDocFile->getId())
                    ->setField('id')
            )
        ;

        return $this->packageDocFileSchema->update(
            $this->packageDocFileFactory->arrayToUpdate($packageDocFile, $fields),
            $filter
        );
    }

    public function delete(Filter $filter): int
    {
        return $this->packageDocFileSchema->delete($filter);
    }

    public function findOne(?object ...$dtoList):? ContractorPackageDocFile
    {
        $packageDocFile = $this->packageDocFileSchema->findOne(...$dtoList);

        if (null === $packageDocFile) {
            throw new EntityNotFoundException('Contractor package doc file was not found');
        }

        return $this->packageDocFileFactory->createEntity($packageDocFile);
    }

    public function exists(Filter $filter): bool
    {
        return $this->packageDocFileSchema->exists($filter);
    }
}
