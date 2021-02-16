<?php

namespace Eds\CustomFields\Value;

use Eds\CustomFields\Value\Attributes\CustomFieldBooleanAttributes;
use Eds\CustomFields\Value\Attributes\CustomFieldClientDataListAttributes;
use Eds\CustomFields\Value\Attributes\CustomFieldSystemDataListAttributes;
use Eds\CustomFields\Value\Attributes\CustomFieldDateAttributes;
use Eds\CustomFields\Value\Attributes\CustomFieldFloatAttributes;
use Eds\CustomFields\Value\Attributes\CustomFieldIntegerAttributes;
use Eds\CustomFields\Value\Attributes\CustomFieldNumericAttributes;
use Eds\CustomFields\Value\Attributes\CustomFieldTextAttributes;
use OutOfRangeException;

class CustomFieldType
{
    public const TYPE_TEXT = 'text';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_FLOAT = 'float';
    public const TYPE_NUMERIC = 'numeric';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_DATE = 'date';
    public const TYPE_SYSTEM_LIST = 'systemList';
    public const TYPE_CLIENT_LIST = 'clientList';

    public const CUSTOM_FIELD_TYPE_LIST = [
        self::TYPE_TEXT,
        self::TYPE_INTEGER,
        self::TYPE_FLOAT,
        self::TYPE_NUMERIC,
        self::TYPE_BOOLEAN,
        self::TYPE_DATE,
        self::TYPE_SYSTEM_LIST,
        self::TYPE_CLIENT_LIST,
    ];

    private array $data;
    /** @var CustomFieldIntegerAttributes|CustomFieldTextAttributes|null */
    private $attributes = null;

    public function __construct(array $data)
    {
        $this->data = $data;

        if (isset($data['attributes'])) {
            $this->attributes = $this->createAttributes($data['attributes'], $data['type']);
        }
    }

    private function createAttributes(array $attributes, string $type)
    {
        switch ($type) {
            case self::TYPE_TEXT:
                return new CustomFieldTextAttributes($attributes);
            case self::TYPE_INTEGER:
                return new CustomFieldIntegerAttributes($attributes);
            case self::TYPE_FLOAT:
                return new CustomFieldFloatAttributes($attributes);
            case self::TYPE_NUMERIC:
                return new CustomFieldNumericAttributes($attributes);
            case self::TYPE_BOOLEAN:
                return new CustomFieldBooleanAttributes($attributes);
            case self::TYPE_DATE:
                return new CustomFieldDateAttributes($attributes);
            case self::TYPE_SYSTEM_LIST:
                return new CustomFieldSystemDataListAttributes($attributes);
            case self::TYPE_CLIENT_LIST:
                return new CustomFieldClientDataListAttributes($attributes);
            default:
                throw new OutOfRangeException('Unknown type of custom field');
        }
    }

    public function toArray(): array
    {
        $this->data['attributes'] = is_null($this->attributes) ? null : json_encode($this->attributes);

        return $this->data;
    }
}
