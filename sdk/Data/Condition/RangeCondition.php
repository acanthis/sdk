<?php

namespace Nrg\Data\Condition;

use Nrg\Data\Abstraction\ConditionInterface;
use Nrg\Utility\PopulateProps;

class RangeCondition implements ConditionInterface
{
    use FieldTrait;
    use PopulateProps;

    private ?string $min = null;
    private ?string $max = null;

    public function __construct(array $data = [])
    {
        $this->populateProps($data);
    }

    public function setMin(string $min): RangeCondition
    {
        $this->min = $min;

        return $this;
    }

    public function setMax(string $max): RangeCondition
    {
        $this->max = $max;

        return $this;
    }

    public function getMin(): ?string
    {
        return $this->min;
    }

    public function getMax(): ?string
    {
        return $this->max;
    }

    public function getParameters(): array
    {
        if (null === $this->getMin()) {
            return [
                $this->getMax(),
            ];
        }
        if (null === $this->getMax()) {
            return [
                $this->getMin(),
            ];
        }

        return [
            $this->getMin(),
            $this->getMax(),
        ];
    }
}
