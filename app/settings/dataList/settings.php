<?php

use Eds\DataList\Action\DataList\DataListCreateAction;
use Eds\DataList\Action\DataList\DataListListAction;
use Eds\DataList\Action\DataList\DataListListValuesAction;
use Eds\DataList\Action\DataList\DataListMarkAsDeleteAction;
use Eds\DataList\Action\DataList\DataListReadAction;
use Eds\DataList\Action\DataList\DataListUnMarkAsDeleteAction;
use Eds\DataList\Action\DataList\DataListUpdateAction;
use Eds\DataList\Action\DataListValue\DataListValueCreateAction;
use Eds\DataList\Action\DataListValue\DataListValueMarkAsDeleteAction;
use Eds\DataList\Action\DataListValue\DataListValueReadAction;
use Eds\DataList\Action\DataListValue\DataListValueUnMarkAsDeleteAction;
use Eds\DataList\Action\DataListValue\DataListValueUpdateAction;
use Eds\DataList\Persistence\Abstraction\Repository\DataListRepositoryInterface;
use Eds\DataList\Persistence\Abstraction\Repository\DataListValueRepositoryInterface;
use Eds\DataList\Persistence\Repository\PgSqlDataListRepository;
use Eds\DataList\Persistence\Repository\PgSqlDataListValueRepository;
use Eds\DataList\Persistence\Schema\PgSqlDataListSchema;
use Eds\DataList\Persistence\Schema\PgSqlDataListValueSchema;

return [
    'routes' => [
        '/data_list/create' => DataListCreateAction::class,
        '/data_list/update' => DataListUpdateAction::class,
        '/data_list/read' => DataListReadAction::class,
        '/data_list/mark_as_delete' => DataListMarkAsDeleteAction::class,
        '/data_list/unmark_as_delete' => DataListUnMarkAsDeleteAction::class,
        '/data_list/list' => DataListListAction::class,
        '/data_list/list_values' => DataListListValuesAction::class,
        '/data_list_value/create' => DataListValueCreateAction::class,
        '/data_list_value/update' => DataListValueUpdateAction::class,
        '/data_list_value/read' => DataListValueReadAction::class,
        '/data_list_value/mark_as_delete' => DataListValueMarkAsDeleteAction::class,
        '/data_list_value/unmark_as_delete' => DataListValueUnMarkAsDeleteAction::class,
    ],
    'services' => [
        DataListRepositoryInterface::class => PgSqlDataListRepository::class,
        DataListValueRepositoryInterface::class => PgSqlDataListValueRepository::class,
        PgSqlDataListSchema::class => [PgSqlDataListSchema::class, 'tableName' => $_ENV['DATA_LIST_DB_TABLE_NAME']],
        PgSqlDataListValueSchema::class => [PgSqlDataListValueSchema::class, 'tableName' => $_ENV['DATA_LIST_VALUES_DB_TABLE_NAME']],
    ],
];
