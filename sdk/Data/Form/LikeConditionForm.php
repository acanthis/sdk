<?php

namespace Nrg\Data\Form;

use Nrg\Data\Form\Element\ConditionValueElement;
use Nrg\Form\Validator\ScalarValidator;

class LikeConditionForm extends ConditionForm
{
    private const TYPE_OPERAND_STARTS = 1;
    private const TYPE_OPERAND_ENDS = 2;
    private const TYPE_OPERAND_CONTAINS = 3;
    private const TYPE_OPERAND_EQUALS = 4;

    private bool $forceCaseInsensitivity = false;
    private int $typeOperand = self::TYPE_OPERAND_CONTAINS;

    public function __construct()
    {
        parent::__construct();

        $this
            ->addElement(
                (new ConditionValueElement())
                    ->addValidator(new ScalarValidator())
            )
        ;
    }

    public function setTypeOperand(int $typeOperand): LikeConditionForm
    {
        $this->typeOperand = $typeOperand;

        return $this;
    }

    public function getTypeOperand(): int
    {
        return $this->typeOperand;
    }

    public function setForceCaseInsensitivity(bool $forceCaseInsensitivity): LikeConditionForm
    {
        $this->forceCaseInsensitivity = $forceCaseInsensitivity;

        return $this;
    }

    public function isForceCaseInsensitivity(): bool
    {
        return $this->forceCaseInsensitivity;
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

    protected function getConditionName(): string
    {
        return 'like';
    }
}
