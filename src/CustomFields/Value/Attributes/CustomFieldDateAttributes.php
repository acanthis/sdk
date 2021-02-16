<?php

namespace Eds\CustomFields\Value\Attributes;

use JsonSerializable;

class CustomFieldDateAttributes implements JsonSerializable
{
    private ?string $min = null;
    private ?string $max = null;
    private ?string $defaultValue = null;

    public function __construct(array $value)
    {
        $this->min = $value['min'] ?? null;
        $this->max = $value['max'] ?? null;
        $this->defaultValue = $value['defaultValue'] ?? null;
    }

    public function jsonSerialize()
    {
        $result = [];

        if ($this->min) {
            $result['min'] = $this->min;
        }

        if ($this->max) {
            $result['max'] = $this->max;
        }

        if ($this->defaultValue) {
            $result['defaultValue'] = $this->defaultValue;
        }

        return $result;
    }
}
