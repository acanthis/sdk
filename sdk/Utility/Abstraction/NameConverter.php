<?php

namespace Nrg\Utility\Abstraction;

interface NameConverter
{
    public function toSnakeCase(string $propertyName): string;

    public function toCamelCase(string $propertyName): string;
}
