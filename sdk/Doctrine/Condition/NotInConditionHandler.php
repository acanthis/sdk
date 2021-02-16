<?php

namespace Nrg\Doctrine\Condition;

use Doctrine\DBAL\Query\Expression\CompositeExpression;
use Nrg\Data\Abstraction\ConditionInterface;

class NotInConditionHandler extends ConditionHandler
{
    public function handle(ConditionInterface $condition, CompositeExpression $expression): void
    {
        $expression->add($this->getQuery()->expr()->notIn($condition->getField(), '?'));
    }
}
