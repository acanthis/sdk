<?php

namespace Nrg\Data\Dto;

use ArrayIterator;
use IteratorAggregate;

class Metadata implements IteratorAggregate
{
    private Filter $filter;
    private Sorting $sorting;
    private Pagination $pagination;

    public function __construct(array $data)
    {
        $this->filter = (new Filtering($data))->getFilter();
        $this->sorting = new Sorting($data);
        $this->pagination = new Pagination($data);
    }

    public function getFilter(): Filter
    {
        return $this->filter;
    }

    public function getSorting(): Sorting
    {
        return $this->sorting;
    }

    public function getPagination(): Pagination
    {
        return $this->pagination;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator([
            $this->getFilter(),
            $this->getSorting(),
            $this->getPagination(),
        ]);
    }
}
