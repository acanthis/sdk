<?php

namespace Nrg\Utility\Service;

class CaseStyleConverter
{
    private const SNAKE_CASE_DELIMITER = '_';

    public function toSnakeCase(string $string): string
    {
        return strtolower(
            preg_replace(
                ['/([A-Z]+)/', '/_([A-Z]+)([A-Z][a-z])/'],
                ['_$1', '_$1_$2'],
                lcfirst($string)
            )
        );
    }

    public function toCamelCase(string $string): string
    {
        return str_replace(
            self::SNAKE_CASE_DELIMITER,
            '',
            lcfirst(ucwords($string, self::SNAKE_CASE_DELIMITER))
        );
    }
}
