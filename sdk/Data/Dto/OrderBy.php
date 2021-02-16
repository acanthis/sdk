<?php

namespace Nrg\Data\Dto;

use Nrg\Utility\PopulateProps;

class OrderBy
{
    use PopulateProps;

    public const SORT_BY_ASC = 'asc';
    public const SORT_BY_DESC = 'desc';

    private string $field;
    private string $sortBy = self::SORT_BY_ASC;

    public function __construct(array $data = [])
    {
        $this->populateProps($data);
    }

    public function setField(string $field): void
    {
        $this->field = $field;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getSortBy(): string
    {
        return $this->sortBy;
    }

    private function setSortBy(string $sortBy): void
    {
        $this->sortBy = strtolower($sortBy);
    }
}
