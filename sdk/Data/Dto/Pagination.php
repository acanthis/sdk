<?php

namespace Nrg\Data\Dto;

use InvalidArgumentException;
use Nrg\Utility\PopulateProps;

class Pagination
{
    use PopulateProps;

    public const MIN_LIMIT = 1;
    public const MAX_LIMIT = 1000;
    public const MIN_OFFSET = 0;

    private const LITERAL_MIN_LIMIT = 'minLimit';
    private const LITERAL_MAX_LIMIT = 'maxLimit';
    private const LITERAL_MIN_OFFSET = 'minOffset';
    private const DEFAULT_LIMIT = 50;

    private int $limit = self::DEFAULT_LIMIT;
    private int $maxLimit = self::MAX_LIMIT;
    private int $offset = 0;
    private array $errorMessages = [
        self::LITERAL_MIN_LIMIT => 'The limit should not be less than %d.',
        self::LITERAL_MAX_LIMIT => 'The limit should not be greater than %d.',
        self::LITERAL_MIN_OFFSET => 'The offset should not be less than %d.',
    ];

    public function __construct(array $data = [])
    {
        $this->populateProps($data);
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function setMaxLimit(int $maxLimit): Pagination
    {
        $this->maxLimit = $maxLimit;

        return $this;
    }

    public function setLimit(int $limit): Pagination
    {
        if (self::MIN_LIMIT > $limit) {
            throw new InvalidArgumentException(
                sprintf($this->errorMessages[self::LITERAL_MIN_LIMIT], self::MIN_LIMIT)
            );
        }

        if ($this->maxLimit < $limit) {
            throw new InvalidArgumentException(
                sprintf($this->errorMessages[self::LITERAL_MAX_LIMIT], $this->maxLimit)
            );
        }

        $this->limit = $limit;

        return $this;
    }

    public function setOffset(int $offset): Pagination
    {
        if (self::MIN_OFFSET > $offset) {
            throw new InvalidArgumentException(
                sprintf($this->errorMessages[self::LITERAL_MIN_OFFSET], self::MIN_OFFSET)
            );
        }

        $this->offset = $offset;

        return $this;
    }
}
