<?php

namespace Eds\CustomFields\Value\Attributes;

use JsonSerializable;

class CustomFieldBooleanAttributes implements JsonSerializable
{
    private ?bool $defaultValue = null;

    public function __construct(array $value)
    {
        $this->defaultValue = $value['defaultValue'] ?? null;
    }

    public function jsonSerialize()
    {
        $result = [];

        if ($this->defaultValue) {
            $result['defaultValue'] = $this->defaultValue;
        }

        return $result;
    }
}
