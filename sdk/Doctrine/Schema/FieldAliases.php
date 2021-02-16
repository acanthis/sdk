<?php

namespace Nrg\Doctrine\Schema;

trait FieldAliases
{
    public function getFields(string $alias, array $fields): array
    {
        return array_map(function ($field) use ($alias) {
            return $alias . '.' . $field;
        }, $fields);
    }

    public function getFieldAliases(string $alias, array $fields): array
    {
        return array_map(function ($field) use ($alias) {
            return $alias . '.' . $field . ' as "' . $alias . '.' . $field . '"';
        }, $fields);
    }
}