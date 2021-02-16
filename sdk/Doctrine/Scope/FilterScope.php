<?php

namespace Nrg\Doctrine\Scope;

use Doctrine\DBAL\Query\Expression\CompositeExpression;
use Doctrine\DBAL\Query\QueryBuilder;
use Nrg\Data\Abstraction\ConditionInterface;
use Nrg\Data\Abstraction\ScopeInterface;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Condition\GreaterCondition;
use Nrg\Data\Condition\GreaterOrEqualCondition;
use Nrg\Data\Condition\InCondition;
use Nrg\Data\Condition\LessCondition;
use Nrg\Data\Condition\LessOrEqualCondition;
use Nrg\Data\Condition\LikeCondition;
use Nrg\Data\Condition\NotEqualCondition;
use Nrg\Data\Condition\NotInCondition;
use Nrg\Data\Condition\NotLikeCondition;
use Nrg\Data\Condition\OutRangeCondition;
use Nrg\Data\Condition\RangeCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Doctrine\Condition\ConditionHandler;
use Nrg\Doctrine\Condition\EqualConditionHandler;
use Nrg\Doctrine\Condition\GreaterConditionHandler;
use Nrg\Doctrine\Condition\GreaterOrEqualConditionHandler;
use Nrg\Doctrine\Condition\InConditionHandler;
use Nrg\Doctrine\Condition\LessConditionHandler;
use Nrg\Doctrine\Condition\LessOrEqualConditionHandler;
use Nrg\Doctrine\Condition\LikeConditionHandler;
use Nrg\Doctrine\Condition\NotEqualConditionHandler;
use Nrg\Doctrine\Condition\NotInConditionHandler;
use Nrg\Doctrine\Condition\NotLikeConditionHandler;
use Nrg\Doctrine\Condition\OutRangeConditionHandler;
use Nrg\Doctrine\Condition\RangeConditionHandler;
use Nrg\Doctrine\Utility\DataTypes;
use RuntimeException;

class FilterScope implements ScopeInterface
{
    use DataTypes;

    private Filter $filter;

    private array $handlerMap = [
        EqualCondition::class => EqualConditionHandler::class,
        NotEqualCondition::class => NotEqualConditionHandler::class,
        GreaterCondition::class => GreaterConditionHandler::class,
        GreaterOrEqualCondition::class => GreaterOrEqualConditionHandler::class,
        LessCondition::class => LessConditionHandler::class,
        LessOrEqualCondition::class => LessOrEqualConditionHandler::class,
        LikeCondition::class => LikeConditionHandler::class,
        NotLikeCondition::class => NotLikeConditionHandler::class,
        InCondition::class => InConditionHandler::class,
        NotInCondition::class => NotInConditionHandler::class,
        RangeCondition::class => RangeConditionHandler::class,
        OutRangeCondition::class => OutRangeConditionHandler::class
    ];

    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }

    public function apply(QueryBuilder $query): void
    {
        $this->applyFilter($this->filter, $query);
    }

    private function applyFilter(
        Filter $filter,
        QueryBuilder $query,
        CompositeExpression $expression = null,
        array &$parameters = []
    ): void {
        if ($this->filter->isEmpty()) {
            return;
        }

        if (Filter::UNION_AND === $filter->getUnion()) {
            $filterExpression = $query->expr()->andX();
        } else {
            $filterExpression = $query->expr()->orX();
        }

        foreach ($filter->getConditions() as $condition) {
            $this->applyCondition(
                $condition,
                $query,
                $filterExpression,
                $parameters
            );
        }

        foreach ($filter->getFilters() as $subFilter) {
            $this->applyFilter(
                $subFilter,
                $query,
                $filterExpression,
                $parameters
            );
        }

        if (null !== $expression) {
            $expression->add($filterExpression);
        } else {
            $query
                ->where($filterExpression)
                ->setParameters($parameters, $this->getDataTypes($parameters));
        }
    }

    private function applyCondition(
        ConditionInterface $condition,
        QueryBuilder $query,
        CompositeExpression $expression,
        array &$parameters = []
    ): void {
        $this
            ->getConditionHandler($condition, $query)
            ->handle($condition, $expression);

        $parameters = [
            ...$parameters,
            ...$condition->getParameters(),
        ];
    }

    private function getConditionHandler(
        ConditionInterface $condition,
        QueryBuilder $query
    ): ConditionHandler {
        $conditionClass = get_class($condition);
        $handler = $this->handlerMap[$conditionClass] ?? null;

        if (null === $handler) {
            throw new RuntimeException(
                sprintf('Condition handler for \'%s\' was not found', $conditionClass)
            );
        }

        if (is_string($handler)) {
            $this->handlerMap[$conditionClass] = new $handler($query);
        }

        return $this->handlerMap[$conditionClass];
    }
}
