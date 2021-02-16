<?php

namespace Nrg\Form\Helper;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\FilterInterface;

trait FiltersTrait
{
    /** @var FilterInterface[] */
    private array $filters = [];

    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;

        return $this;
    }

    /** @return  FilterInterface[] */
    protected function getFilters(): array
    {
        return $this->filters;
    }

    protected function applyFilters()
    {
        foreach ($this->getFilters() as $filter) {
            $filter->apply($this);
        }
    }
}
