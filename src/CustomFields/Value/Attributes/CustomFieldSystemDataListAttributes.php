<?php

namespace Eds\CustomFields\Value\Attributes;

use JsonSerializable;

class CustomFieldSystemDataListAttributes implements JsonSerializable
{
    private string $relationName;

    public function __construct(array $value)
    {
        $this->relationName = $value['relationName'];
    }

    public function jsonSerialize(): array
    {
        return [
            'relationName' => $this->relationName
        ];
    }
}
