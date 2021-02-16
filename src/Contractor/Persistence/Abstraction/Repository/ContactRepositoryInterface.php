<?php

namespace Eds\Contractor\Persistence\Abstraction\Repository;

use Eds\Common\Persistence\Abstraction\Repository\BaseRepositoryInterface;
use Eds\Contractor\Entity\ContractorContact;

interface ContactRepositoryInterface extends BaseRepositoryInterface
{
    public function create(ContractorContact $contractorContact): void;

    public function update(ContractorContact $contractorContact, array $fields = null): int;

    public function setAllDefault(ContractorContact $excludeContact): int;

    public function findOne(?object ...$dtoList): ?ContractorContact;
}
