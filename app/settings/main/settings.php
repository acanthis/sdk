<?php

use Eds\Common\Action\ApiStatusAction;
use Nrg\Doctrine\Abstraction\Connection;
use Nrg\Doctrine\Connection\PgSqlConnection;
use Nrg\Http\Abstraction\ResponseEmitter;
use Nrg\Http\Abstraction\RouteProvider;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Middleware\AllowCors;
use Nrg\Http\Middleware\EmitResponse;
use Nrg\Http\Middleware\ErrorHandler;
use Nrg\Http\Middleware\ParseJsonRequest;
use Nrg\Http\Middleware\ResponsePayload;
use Nrg\Http\Middleware\RunAction;
use Nrg\Http\Middleware\SerializeJsonResponse;
use Nrg\Http\Service\HttpResponseEmitter;
use Nrg\Http\Service\HttpRouteProvider;
use Nrg\Rx\Abstraction\EventProvider;
use Nrg\Rx\Service\RxEventProvider;
use Nrg\Utility\Abstraction\Config;
use Nrg\Utility\Abstraction\UuidGenerator;
use Nrg\Utility\Service\ArrayConfig;
use Nrg\Utility\Service\PseudoRandomUuidGenerator;

return [
    'routes' => [
        '/' => ApiStatusAction::class,
    ],
    'services' => [
        Config::class => ArrayConfig::class,
        EventProvider::class => RxEventProvider::class,
        RouteProvider::class => HttpRouteProvider::class,
        ResponseEmitter::class => HttpResponseEmitter::class,
        Connection::class => [
            PgSqlConnection::class,
            'config' => [
                'host' => $_ENV['DB_HOST'],
                'port' => $_ENV['DB_PORT'],
                'dbname' => $_ENV['DB_NAME'],
                'schemaName' => $_ENV['DB_SCHEMA'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD'],
            ],
        ],
        UuidGenerator::class => PseudoRandomUuidGenerator::class,
    ],
    'events' => [
        HttpExchangeEvent::class => [
            AllowCors::class,
            ErrorHandler::class,
            ParseJsonRequest::class,
            RunAction::class,
            ResponsePayload::class,
            SerializeJsonResponse::class,
            EmitResponse::class,
        ],
    ],
];
