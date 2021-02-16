<?php

namespace Eds\CustomFields\Dto;

use Eds\CustomFields\Value\CustomFieldType;

class CustomFieldCreateInput
{
    /** @var CustomFieldType[] */
    private array $customFields = [];

    public function __construct(array $data)
    {
        foreach ($data as $item) {
            $this->customFields[] = new CustomFieldType($item);
        }
    }

    /** @return CustomFieldType[] */
    public function getCustomFields(): array
    {
        return $this->customFields;
    }
}