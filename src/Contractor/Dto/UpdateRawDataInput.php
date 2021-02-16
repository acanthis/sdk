<?php

namespace Eds\Contractor\Dto;

class UpdateRawDataInput
{
    private array $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function hasChanged(array $prevData): bool
    {
        foreach ($this->data as $field => $value) {
            if ($prevData[$field] !== $value) {
                return true;
            }
        }

        return false;
    }
}
