<?php

namespace Nrg\Form\Helper;

trait ValueTrait
{
    use IsEmptyTrait;

    private $value;

    private bool $hasValue = false;

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): self
    {
        $this->reset();
        $this->value = $value;
        $this->hasValue = true;

        return $this;
    }

    public function hasValue(): bool
    {
        return $this->hasValue;
    }

    public function hasEmptyValue(): bool
    {
        return $this->isEmpty($this->getValue());
    }

    public function reset(): self
    {
        $this->value = null;
        $this->hasValue = false;

        // todo: reset $this->errors = null (see ErrorsTrait)

        return $this;
    }
}
