<?php

namespace Eds\CustomFields\Value\Attributes;

use JsonSerializable;

class CustomFieldTextAttributes implements JsonSerializable
{
    private ?int $minLength = null;
    private ?int $maxLength = null;
    private ?string $defaultValue = null;

    public function __construct(array $value)
    {
        $this->minLength = $value['minLength'] ?? null;
        $this->maxLength = $value['maxLength'] ?? null;
        $this->defaultValue = $value['defaultValue'] ?? null;
    }

    public function jsonSerialize()
    {
        $result = [];

        if ($this->minLength) {
            $result['minLength'] = $this->minLength;
        }

        if ($this->maxLength) {
            $result['maxLength'] = $this->maxLength;
        }

        if ($this->defaultValue) {
            $result['defaultValue'] = $this->defaultValue;
        }

        return $result;
    }
}
