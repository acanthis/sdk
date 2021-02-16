<?php

namespace Nrg\Doctrine\Utility;

use Doctrine\DBAL\Connection;
use PDO;

trait DataTypes
{
    protected function getDataTypes(array $data): array
    {
        $result = [];

        foreach ($data as $value) {
            $result[] = $this->getValueType($value);
        }

        return $result;
    }

    protected function getValueType($parameter): int
    {
        if (is_array($parameter)) {
            switch (gettype(current($parameter))) {
                case 'integer':
                    return Connection::PARAM_INT_ARRAY;
                case 'string':
                default:
                    return Connection::PARAM_STR_ARRAY;
            }
        } else {
            switch (gettype($parameter)) {
                case 'integer':
                    return PDO::PARAM_INT;
                case 'boolean':
                    return PDO::PARAM_BOOL;
                case 'string':
                default:
                    return PDO::PARAM_STR;
            }
        }
    }
}
