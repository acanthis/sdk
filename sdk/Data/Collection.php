<?php

namespace Nrg\Data;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;

class Collection implements IteratorAggregate, Countable, JsonSerializable
{
    private array $data = [];

    private ?int $total = null;

    public function addEntity(object $entity): Collection
    {
        $this->data[] = $entity;

        return $this;
    }

    public function setData(array $data): Collection
    {
        $this->data = $data;

        return $this;
    }

    public function setTotal(int $total): Collection
    {
        $this->total = $total;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function isEmpty(): bool
    {
        return empty($this);
    }

    public function count(): int
    {
        return count($this->getData());
    }

    public function getIterator()
    {
        return new ArrayIterator($this->getData());
    }

    public function jsonSerialize(): array
    {
        return [
            'total' => $this->getTotal(),
            'data' => $this->getData(),
        ];
    }
}
