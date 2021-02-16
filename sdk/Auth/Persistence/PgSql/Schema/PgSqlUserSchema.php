<?php

namespace Nrg\Auth\Persistence\PgSql\Schema;

use Iterator;
use Nrg\Data\Dto\Filter;
use Nrg\Doctrine\Schema\PgSqlSchema;

class PgSqlUserSchema extends PgSqlSchema
{
    public function findAll(object ...$dtoList): Iterator
    {
        $statement = $this->query($dtoList)
            ->select('*')
            ->from($this->getTableName())
            ->execute()
        ;

        while ($data = $statement->fetch()) {
            yield $this->dataToCamelCase($data);
        }
    }

    public function findOne(object ...$dtoList): ?array
    {
        $data = $this->query($dtoList)
            ->select('*')
            ->from($this->getTableName())
            ->execute()
            ->fetch()
        ;

        return false === $data ? null : $this->dataToCamelCase($data);
    }

    public function count(Filter $filter): int
    {
        return $this->query([$filter])
            ->select('COUNT(*)')
            ->from($this->getTableName())
            ->execute()
            ->fetchColumn()
        ;
    }

    public function exists(Filter $filter): bool
    {
        return $this->count($filter) > 0 ? true : false;
    }

    public function insert(array $data): void
    {
        $this->getConnection()->insert(
            $this->getTableName(),
            $this->dataToSnakeCase($data),
            $this->getDataTypes($data)
        );
    }

    public function update(array $data, object ...$dtoList): int
    {
        $query = $this->query($dtoList)
            ->update($this->getTableName())
        ;

        $valueParameters = [];

        foreach ($this->dataToSnakeCase($data) as $field => $value) {
            $query->set($field, '?');
            $valueParameters[] = $value;
        }

        $query->setParameters(
            [
                ...$valueParameters,
                ...$query->getParameters(),
            ],
            $this->getDataTypes($data)
        );

        return $query->execute();
    }

    public function delete(Filter $filter): int
    {
        return $this->query([$filter])
            ->delete($this->getTableName())
            ->execute()
        ;
    }
}
