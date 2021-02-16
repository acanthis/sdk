<?php

namespace Nrg\Doctrine\Schema;

use Doctrine\DBAL\Query\QueryBuilder;
use Nrg\Data\Dto\Filter;
use Nrg\Data\Dto\Sorting;
use Nrg\Data\Service\CaseStyleSchemaAdapter;
use Nrg\Doctrine\Abstraction\Connection;

class PgSqlSchema extends SqlSchema
{
    private const RELATION_DELIMITER = '.';

    private CaseStyleSchemaAdapter $schemaAdapter;

    public function __construct(
        Connection $connection,
        CaseStyleSchemaAdapter $schemaAdapter,
        string $tableName
    ) {
        parent::__construct($connection, $tableName);
        $this->schemaAdapter = $schemaAdapter;
    }

    public function dataToSnakeCase(array $data): array
    {
        return $this->getSchemaAdapter()->dataToSnakeCase($data);
    }

    public function explodeRelations(array $data): array
    {
        foreach ($data as $field => $value) {
            if (strstr($field, self::RELATION_DELIMITER)) {
                list($table, $field2) = explode(self::RELATION_DELIMITER, $field);
                $data[$table][$field2] = $value;
                unset($data[$field]);
            }
        }

        return $data;
    }

    public function dataToCamelCase(array $data): array
    {
        return $this->getSchemaAdapter()->dataToCamelCase($data);
    }

    protected function fieldsToSnakeCase(array $fields): array
    {
        return $this->getSchemaAdapter()->fieldsToSnakeCase($fields);
    }

    public function query(array $dtoList, ?string $baseAlias = null): QueryBuilder
    {
        return $this->createQuery(...$this->createScopes($this->adaptDto($dtoList, $baseAlias)));
    }

    /* @return Filter[]|Sorting[] */
    private function adaptDto(array $dtoList, ?string $baseAlias): array
    {
        $adaptedDtoList = [];

        foreach ($dtoList as $dto) {
            switch (true) {
                case $dto instanceof Filter:
                    $cloneDto = clone $dto;
                    $this->getSchemaAdapter()->filterToSnakeCase($cloneDto, $baseAlias);
                    $adaptedDtoList[] = $cloneDto;
                    break;
                case $dto instanceof Sorting:
                    $cloneDto = clone $dto;
                    $this->getSchemaAdapter()->sortingToSnakeCase($cloneDto, $baseAlias);
                    $adaptedDtoList[] = $cloneDto;
                    break;
                default:
                    $adaptedDtoList[] = $dto;
            }
        }

        return $adaptedDtoList;
    }

    protected function getSchemaAdapter(): CaseStyleSchemaAdapter
    {
        return $this->schemaAdapter;
    }
}
