<?php

namespace Nrg\Utility\Abstraction;

interface UuidGenerator
{
    public function generateV4(): string;

    public function isValidV4(string $value): bool;
}
