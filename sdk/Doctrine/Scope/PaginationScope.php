<?php

namespace Nrg\Doctrine\Scope;

use Doctrine\DBAL\Query\QueryBuilder;
use Nrg\Data\Abstraction\ScopeInterface;
use Nrg\Data\Dto\Pagination;

class PaginationScope implements ScopeInterface
{
    private Pagination $pagination;

    public function __construct(Pagination $pagination)
    {
        $this->pagination = $pagination;
    }

    public function apply(QueryBuilder $query): void
    {
        $query
            ->setFirstResult($this->pagination->getOffset())
            ->setMaxResults($this->pagination->getLimit())
        ;
    }
}
