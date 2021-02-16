<?php

namespace Nrg\Data\Condition;

use Nrg\Data\Abstraction\ConditionInterface;
use Nrg\Utility\PopulateProps;

class LikeCondition implements ConditionInterface
{
    use FieldTrait;
    use PopulateProps;

    private const TYPE_OPERAND_STARTS = 1;
    private const TYPE_OPERAND_ENDS = 2;
    private const TYPE_OPERAND_CONTAINS = 3;
    private const TYPE_OPERAND_EQUALS = 4;

    private string $value;
    private bool $forceCaseInsensitivity = false;
    private int $typeOperand = self::TYPE_OPERAND_CONTAINS;

    public function __construct(array $data)
    {
        $this->populateProps($data);
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setTypeOperand(int $typeOperand): void
    {
        $this->typeOperand = $typeOperand;
    }

    public function getTypeOperand(): int
    {
        return $this->typeOperand;
    }

    public function setForceCaseInsensitivity(bool $forceCaseInsensitivity): void
    {
        $this->forceCaseInsensitivity = $forceCaseInsensitivity;
    }

    public function isForceCaseInsensitivity(): bool
    {
        return $this->forceCaseInsensitivity;
    }

    public function getParameters(): array
    {
        return [
            $this->getValue(),
        ];
    }

    public static function convertTypeOperandToMask(string $value, int $typeOperand, bool $forceCaseInsensitivity): string
    {
        if (!$forceCaseInsensitivity) {
            $value = mb_strtolower($value);
        }

        switch ($typeOperand) {
            case self::TYPE_OPERAND_STARTS:
                $value .= '%';

                break;
            case self::TYPE_OPERAND_ENDS:
                $value = '%'.$value;

                break;
            case self::TYPE_OPERAND_CONTAINS:
                $value = '%'.$value.'%';

                break;
            case self::TYPE_OPERAND_EQUALS:
            default:
                break;
        }

        return $value;
    }
}
