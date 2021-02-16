<?php

namespace Nrg\Doctrine\Condition;

use Doctrine\DBAL\Query\Expression\CompositeExpression;
use Nrg\Data\Abstraction\ConditionInterface;

class EqualConditionHandler extends ConditionHandler
{
    public function handle(ConditionInterface $condition, CompositeExpression $expression): void
    {
        $expression->add($this->getQuery()->expr()->eq($condition->getField(), '?'));
    }
}
