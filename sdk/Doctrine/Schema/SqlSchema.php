<?php

namespace Nrg\Doctrine\Schema;

use Doctrine\DBAL\Query\QueryBuilder;
use LogicException;
use Nrg\Data\Abstraction\ScopeInterface;
use Nrg\Data\Dto\Filter;
use Nrg\Data\Dto\Pagination;
use Nrg\Data\Dto\Sorting;
use Nrg\Doctrine\Abstraction\Connection;
use Nrg\Doctrine\Scope\FilterScope;
use Nrg\Doctrine\Scope\PaginationScope;
use Nrg\Doctrine\Scope\SortingScope;
use Nrg\Doctrine\Utility\DataTypes;

class SqlSchema
{
    use DataTypes;

    private Connection $connection;

    private string $tableName;

    public function __construct(Connection $connection, string $tableName)
    {
        $this->connection = $connection;
        $this->tableName = $tableName;
    }

    protected function createQuery(ScopeInterface ...$scopes): QueryBuilder
    {
        $query = $this->getConnection()->createQueryBuilder();

        foreach ($scopes as $scope) {
            $scope->apply($query);
        }

        return $query;
    }

    protected function createScopes(array $dtoList): array
    {
        $instances = [];

        foreach ($dtoList as $dto) {
            switch (true) {
                case $dto instanceof Filter:
                    $instances[] = new FilterScope($dto);
                    break;
                case $dto instanceof Sorting:
                    $instances[] = new SortingScope($dto);
                    break;
                case $dto instanceof Pagination:
                    $instances[] = new PaginationScope($dto);
                    break;
                default:
                    throw new LogicException(sprintf('Unknown scope %s', get_class($dto)));
            }
        }

        return $instances;
    }

    protected function getConnection(): Connection
    {
        return $this->connection;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }
}
