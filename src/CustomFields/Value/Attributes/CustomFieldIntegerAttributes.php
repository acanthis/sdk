<?php

namespace Eds\CustomFields\Value\Attributes;

use JsonSerializable;
use Nrg\Utility\PopulateProps;

class CustomFieldIntegerAttributes implements JsonSerializable
{
    use PopulateProps;

    private ?int $min = null;
    private ?int $max = null;
    private ?int $defaultValue = null;

    public function __construct(array $value)
    {
        $this->min = $value['min'] ?? null;
        $this->max = $value['max'] ?? null;
        $this->defaultValue = $value['defaultValue'] ?? null;
    }

    public function jsonSerialize(): array
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
