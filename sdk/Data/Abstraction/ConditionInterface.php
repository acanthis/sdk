<?php

namespace Nrg\Data\Abstraction;

interface ConditionInterface
{
    public function getField(): string;

    public function getParameters(): array;
}
