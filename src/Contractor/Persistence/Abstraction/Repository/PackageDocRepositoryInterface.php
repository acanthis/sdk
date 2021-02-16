<?php

namespace Eds\Contractor\Persistence\Abstraction\Repository;

use Eds\Common\Persistence\Abstraction\Repository\BaseRepositoryInterface;
use Eds\Contractor\Entity\ContractorPackageDoc;

interface PackageDocRepositoryInterface extends BaseRepositoryInterface
{
    public function create(ContractorPackageDoc $contractorPackageDoc): void;

    public function update(ContractorPackageDoc $contractorPackageDoc, array $fields = null): int;

    public function findOne(?object ...$dtoList): ?ContractorPackageDoc;
}
