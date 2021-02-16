<?php

namespace Nrg\Doctrine\Abstraction;

use Doctrine\DBAL\Driver\Connection as DBALConnection;
use Doctrine\DBAL\Exception\InvalidArgumentException;

interface Connection extends DBALConnection
{
    /**
     * Creates a new instance of a SQL query builder.
     *
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function createQueryBuilder();

    /**
     * @param $tableExpression
     */
    public function insert($tableExpression, array $data, array $types = []);

    /**
     * Executes an SQL UPDATE statement on a table.
     *
     * Table expression and columns are not escaped and are not safe for user-input.
     *
     * @param string $tableExpression the expression of the table to update quoted or unquoted
     * @param array  $data            an associative array containing column-value pairs
     * @param array  $identifier      The update criteria. An associative array containing column-value pairs.
     * @param array  $types           types of the merged $data and $identifier arrays in that order
     *
     * @return int the number of affected rows
     */
    public function update($tableExpression, array $data, array $identifier, array $types = []);

    /**
     * Executes an SQL DELETE statement on a table.
     *
     * Table expression and columns are not escaped and are not safe for user-input.
     *
     * @param string $tableExpression the expression of the table on which to delete
     * @param array  $identifier      The deletion criteria. An associative array containing column-value pairs.
     * @param array  $types           the types of identifiers
     *
     * @throws InvalidArgumentException
     *
     * @return int the number of affected rows
     */
    public function delete($tableExpression, array $identifier, array $types = []);
}
