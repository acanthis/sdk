<?php

namespace Nrg\Doctrine\Condition;

use Doctrine\DBAL\Query\Expression\CompositeExpression;
use Doctrine\DBAL\Query\QueryBuilder;
use Nrg\Data\Abstraction\ConditionInterface;

abstract class ConditionHandler
{
    private QueryBuilder $query;

    public function __construct(QueryBuilder $query)
    {
        $this->query = $query;
    }

    abstract public function handle(ConditionInterface $condition, CompositeExpression $expression): void;

    protected function getQuery(): QueryBuilder
    {
        return $this->query;
    }
}
