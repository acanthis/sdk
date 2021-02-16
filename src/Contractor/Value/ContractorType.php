<?php

namespace Eds\Contractor\Value;

use InvalidArgumentException;

class ContractorType
{
    /** Индивидуальный предприниматель */
    public const CONTRACTOR_TYPE_SP = 'SP';

    /** Физлицо */
    public const CONTRACTOR_TYPE_PE = 'PE';

    /** Юрлицо */
    public const CONTRACTOR_TYPE_EN = 'EN';

    public const CONTRACTOR_TYPE_MAP = [ // todo: LIST or TYPES are more fit
        ContractorType::CONTRACTOR_TYPE_SP,
        ContractorType::CONTRACTOR_TYPE_PE,
        ContractorType::CONTRACTOR_TYPE_EN,
    ];

    private string $value;

    public function __construct(string $value)
    {
        if (!in_array($value, self::CONTRACTOR_TYPE_MAP, true)) {
            throw new InvalidArgumentException('contractor_type_unknownType');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function createSP(): ContractorType
    {
        return new self(self::CONTRACTOR_TYPE_SP);
    }

    public static function createPE(): ContractorType
    {
        return new self(self::CONTRACTOR_TYPE_PE);
    }

    public static function createEN(): ContractorType
    {
        return new self(self::CONTRACTOR_TYPE_EN);
    }
}
