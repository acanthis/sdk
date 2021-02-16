<?php

namespace Nrg\Data\Condition;

use Nrg\Data\Abstraction\ConditionInterface;
use Nrg\Utility\PopulateProps;

class EqualCondition implements ConditionInterface
{
    use FieldTrait;
    use PopulateProps;

    private $value;

    public function __construct(array $data = [])
    {
        $this->populateProps($data);
    }

    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getParameters(): array
    {
        return [
            $this->getValue(),
        ];
    }
}
