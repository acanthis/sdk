<?php

namespace Nrg\Data\Abstraction;

use Doctrine\DBAL\Query\QueryBuilder;

interface ScopeInterface
{
    public function apply(QueryBuilder $query): void;
}
