<?php

namespace Nrg\Doctrine\Condition;

use Doctrine\DBAL\Query\Expression\CompositeExpression;
use Nrg\Data\Abstraction\ConditionInterface;
use Nrg\Data\Condition\RangeCondition;

class RangeConditionHandler extends ConditionHandler
{
    /**
     * @param ConditionInterface | RangeCondition $condition
     */
    public function handle(ConditionInterface $condition, CompositeExpression $expression): void
    {
        if (null === $condition->getMin()) {
            $expression->add($this->getQuery()->expr()->lte($condition->getField(), '?'));
        } elseif (null === $condition->getMax()) {
            $expression->add($this->getQuery()->expr()->gte($condition->getField(), '?'));
        } else {
            $expression->add(
                $this->getQuery()->expr()->andX(
                    $this->getQuery()->expr()->gte($condition->getField(), '?'),
                    $this->getQuery()->expr()->lte($condition->getField(), '?')
                )
            );
        }
    }
}
