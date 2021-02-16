<?php

namespace Nrg\Data\Service;

use Nrg\Data\Dto\Filter;
use Nrg\Data\Dto\Metadata;
use Nrg\Data\Dto\Sorting;
use Nrg\Doctrine\Schema\SqlSchema;
use Nrg\Utility\Service\CaseStyleConverter;

class CaseStyleSchemaAdapter
{
    private const RELATION_DELIMITER = '.';
    private CaseStyleConverter $converter;

    public function __construct()
    {
        $this->converter = new CaseStyleConverter();
    }

    public function fieldsToSnakeCase(array $fields): array
    {
        foreach ($fields as $index => $fieldName) {
            $newFieldName = $this->converter->toSnakeCase($fieldName);

            if ($newFieldName !== $fieldName) {
                $fields[$index] = $newFieldName;
            }
        }

        return $fields;
    }

    public function dataToSnakeCase(array $data): array
    {
        foreach ($data as $fieldName => $value) {
            $newFieldName = $this->converter->toSnakeCase($fieldName);

            if ($newFieldName !== $fieldName) {
                $data[$newFieldName] = $value;
                unset($data[$fieldName]);
            }
        }

        return $data;
    }

    public function dataToCamelCase(array $data): array
    {
        foreach ($data as $fieldName => $value) {
            $newFieldName = $this->converter->toCamelCase($fieldName);

            if (is_array($value)) {
                $data[$newFieldName] = $this->dataToCamelCase($value);
                if ($newFieldName !== $fieldName) {
                    unset($data[$fieldName]);
                }
            } else if ($newFieldName !== $fieldName) {
                $data[$newFieldName] = $value;
                unset($data[$fieldName]);
            }

            if ('null' === $value) {
                $data[$newFieldName !== $fieldName ? $newFieldName : $fieldName] = null;
            }
        }

        return $data;
    }

    public function filterToSnakeCase(Filter $filter, ?string $baseAlias): void
    {
        foreach ($filter->getConditions() as $condition) {
            $condition->setField($this->converter->toSnakeCase($this->createFieldName($condition->getField(), $baseAlias)));
        }

        foreach ($filter->getFilters() as $subFilter) {
            $this->filterToSnakeCase($subFilter, $baseAlias);
        }
    }

    public function sortingToSnakeCase(Sorting $sorting, ?string $baseAlias): void
    {
        foreach ($sorting as $orderBy) {
            $orderBy->setField($this->converter->toSnakeCase($this->createFieldName($orderBy->getField(), $baseAlias)));
        }
    }

    private function createFieldName(string $fieldName, ?string $baseAlias): string
    {
        return false === strpos($fieldName, self::RELATION_DELIMITER) && $baseAlias ? "{$baseAlias}.{$fieldName}" : $fieldName;
    }
}
