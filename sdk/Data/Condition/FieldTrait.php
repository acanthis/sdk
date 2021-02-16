<?php

namespace Nrg\Data\Condition;

trait FieldTrait
{
    private string $field;

    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function getField(): string
    {
        return $this->field;
    }
}
