<?php

namespace Eds\CustomFields\Value\Attributes;

use JsonSerializable;

class CustomFieldClientDataListAttributes implements JsonSerializable
{
    private string $relationId;

    public function __construct(array $value)
    {
        $this->relationId = $value['relationId'];
    }

    public function jsonSerialize(): array
    {
        return [
            'relationId' => $this->relationId
        ];
    }
}
