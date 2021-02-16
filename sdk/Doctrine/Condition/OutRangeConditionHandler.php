<?php

namespace Nrg\Doctrine\Condition;

use Doctrine\DBAL\Query\Expression\CompositeExpression;
use Nrg\Data\Abstraction\ConditionInterface;
use Nrg\Data\Condition\OutRangeCondition;

class OutRangeConditionHandler extends ConditionHandler
{
    /**
     * @param ConditionInterface | OutRangeCondition $condition
     */
    public function handle(ConditionInterface $condition, CompositeExpression $expression): void
    {
        if (null === $condition->getMin()) {
            $expression->add($this->getQuery()->expr()->gt($condition->getField(), '?'));
        } elseif (null === $condition->getMax()) {
            $expression->add($this->getQuery()->expr()->lt($condition->getField(), '?'));
        } else {
            $expression->add(
                $this->getQuery()->expr()->orX(
                    $this->getQuery()->expr()->lt($condition->getField(), '?'),
                    $this->getQuery()->expr()->gt($condition->getField(), '?')
                )
            );
        }
    }
}
