<?php

namespace Nrg\Data\Dto;

use ArrayIterator;
use IteratorAggregate;
use Nrg\Utility\PopulateProps;

class Sorting implements IteratorAggregate
{
    use PopulateProps;

    /** @var OrderBy[] */
    private array $orderBy = [];

    public function __construct(array $data = [])
    {
        $this->populateProps($data);
    }

    public function __clone()
    {
        $cloneOrderBy = [];

        foreach ($this->orderBy as $orderBy) {
            $cloneOrderBy[] = clone $orderBy;
        }

        $this->orderBy = $cloneOrderBy;
    }

    /** @return OrderBy[] */
    public function getOrderBy(): array
    {
        return $this->orderBy;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->getOrderBy());
    }

    private function setOrderBy(array $orderBy): void
    {
        foreach ($orderBy as $item) {
            $this->orderBy[] = new OrderBy($item);
        }
    }
}
