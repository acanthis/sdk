<?php

namespace Nrg\Doctrine\Condition;

use Doctrine\DBAL\Query\Expression\CompositeExpression;
use Nrg\Data\Abstraction\ConditionInterface;
use Nrg\Data\Condition\LikeCondition;

class LikeConditionHandler extends ConditionHandler
{
    public function handle(ConditionInterface $condition, CompositeExpression $expression): void
    {
        $condition->setValue(
            LikeCondition::convertTypeOperandToMask(
                $condition->getValue(),
                $condition->getTypeOperand(),
                $condition->isForceCaseInsensitivity()
            )
        );

        $expression->add(
            $this->getQuery()->expr()->like(
                $condition->isForceCaseInsensitivity() ? $condition->getField() : 'lower('.$condition->getField().')',
                '?'
            )
        );
    }
}
