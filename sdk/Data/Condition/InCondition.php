<?php

namespace Nrg\Data\Condition;

use Nrg\Data\Abstraction\ConditionInterface;
use Nrg\Utility\PopulateProps;

class InCondition implements ConditionInterface
{
    use FieldTrait;
    use PopulateProps;

    private array $list = [];

    public function __construct(array $data = [])
    {
        $this->populateProps($data);
    }

    public function setList(array $range): self
    {
        $this->list = $range;

        return $this;
    }

    public function getList(): array
    {
        return $this->list;
    }

    public function getParameters(): array
    {
        return [
            $this->getList(),
        ];
    }
}
