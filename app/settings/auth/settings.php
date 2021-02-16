<?php

use Nrg\Auth\Abstraction\AuthControl;
use Nrg\Auth\Abstraction\ConfigInterface;
use Nrg\Auth\Abstraction\SecureInterface;
use Nrg\Auth\Action\RefreshSigninAction;
use Nrg\Auth\Action\SigninAction;
use Nrg\Auth\Action\SignupAction;
use Nrg\Auth\Action\SignupConfirmationAction;
use Nrg\Auth\Action\UserDeleteAction;
use Nrg\Auth\Action\UserListAction;
use Nrg\Auth\Action\UserUpdateAction;
use Nrg\Auth\Middleware\Authorization;
use Nrg\Auth\Persistence\Abstraction\UserRepository;
use Nrg\Auth\Persistence\PgSql\Repository\PgSqlUserRepository;
use Nrg\Auth\Persistence\PgSql\Schema\PgSqlUserSchema;
use Nrg\Auth\Service\Config;
use Nrg\Auth\Service\JwtAuthControl;
use Nrg\Auth\Service\Secure;

return [
    'routes' => [
        '/signup' => SignupAction::class,
        '/signup/confirmation' => SignupConfirmationAction::class,
        '/signin' => SigninAction::class,
        '/refresh/signin' => RefreshSigninAction::class,
        '/users/update' => UserUpdateAction::class,
        '/users/list' => [
            Authorization::class,
            UserListAction::class,
        ],
        '/users/delete' => UserDeleteAction::class,
    ],
    'services' => [
        AuthControl::class => JwtAuthControl::class,
        UserRepository::class => PgSqlUserRepository::class,
        PgSqlUserSchema::class => [
            PgSqlUserSchema::class,
            'tableName' => $_ENV['AUTH_DB_TABLE_NAME'],
        ],
        SecureInterface::class => Secure::class,
        ConfigInterface::class => [
            Config::class,
            'accessTokenTtl' => $_ENV['AUTH_ACCESS_TOKEN_TTL'],
            'refreshTokenTtl' => $_ENV['AUTH_REFRESH_TOKEN_TTL'],
            'signupConfirmationTokenTtl' => $_ENV['AUTH_SIGNUP_CONFIRMATION_TOKEN_TTL'],
            'saltLength' => $_ENV['AUTH_SALT_LENGTH'],
        ],
    ],
];
