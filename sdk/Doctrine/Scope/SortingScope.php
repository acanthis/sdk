<?php

namespace Nrg\Doctrine\Scope;

use Doctrine\DBAL\Query\QueryBuilder;
use Nrg\Data\Abstraction\ScopeInterface;
use Nrg\Data\Dto\OrderBy;
use Nrg\Data\Dto\Sorting;

class SortingScope implements ScopeInterface
{
    private Sorting $sorting;

    public function __construct(Sorting $sorting)
    {
        $this->sorting = $sorting;
    }

    public function apply(QueryBuilder $query): void
    {
        /** @var OrderBy $orderBy */
        foreach ($this->sorting as $orderBy) {
            $query->addOrderBy($orderBy->getField(), $orderBy->getSortBy());
        }
    }
}
