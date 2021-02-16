<?php

namespace Eds\Contractor\Persistence\Abstraction\Repository;

use Eds\Common\Persistence\Abstraction\Repository\BaseRepositoryInterface;
use Eds\Contractor\Entity\ContractorPackageDocFile;

interface PackageDocFileRepositoryInterface extends BaseRepositoryInterface
{
    public function create(ContractorPackageDocFile $packageDocFile): void;

    public function update(ContractorPackageDocFile $packageDocFile, array $fields = null): int;

    public function findOne(?object ...$dtoList): ?ContractorPackageDocFile;
}
