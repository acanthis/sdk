<?php

namespace Nrg\Doctrine\Connection;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection as DbalConnection;
use Doctrine\DBAL\Driver\PDOPgSql\Driver;
use Nrg\Doctrine\Abstraction\Connection;

class PgSqlConnection extends DbalConnection implements Connection
{
    public function __construct(Configuration $dbalConfig = null, EventManager $eventManager = null, array $config = [])
    {
        $params = $config + ['driver' => 'pdo_pgsql'];

        parent::__construct($params, new Driver(), $dbalConfig, $eventManager);
    }
}
