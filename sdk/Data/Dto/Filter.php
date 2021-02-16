<?php

namespace Nrg\Data\Dto;

use Nrg\Data\Abstraction\ConditionInterface;

class Filter
{
    public const UNION_AND = 'and';
    public const UNION_OR = 'or';

    private array $conditions = [];
    private array $filters = [];
    private string $union;

    public function __construct(string $union = self::UNION_AND)
    {
        $this->union = strtolower($union);
    }

    public function __clone()
    {
        $cloneConditions = [];
        $cloneFilters = [];

        foreach ($this->conditions as $condition) {
            $cloneConditions[] = clone $condition;
        }

        foreach ($this->filters as $filter) {
            $cloneFilters[] = clone $filter;
        }

        $this->conditions = $cloneConditions;
        $this->filters = $cloneFilters;
    }

    public function isEmpty(): bool
    {
        return empty($this->getConditions()) && empty($this->getFilters());
    }

    public function addCondition(ConditionInterface $condition): Filter
    {
        $this->conditions[] = $condition;

        return $this;
    }

    public function addFilter(Filter $filter): Filter
    {
        $this->filters[] = $filter;

        return $this;
    }

    /** @return ConditionInterface[] */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getUnion(): string
    {
        return $this->union;
    }
}
