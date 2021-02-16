<?php

use Dotenv\Dotenv;
use Nrg\Di\Abstraction\Injector;
use Nrg\Di\Service\ReflectionInjector;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Value\CgiRequest;
use Nrg\Http\Value\HttpRequest;
use Nrg\Http\Value\HttpResponse;
use Nrg\Rx\Abstraction\EventProvider;
use Nrg\Utility\Service\ErrorHandler;
use Nrg\Utility\Service\LocalSettings;

require __DIR__.'/../vendor/autoload.php';

try {
    (new ErrorHandler())->enable();

    $dotenv = Dotenv::create(realpath(__DIR__.'/..'));
    $dotenv->load();
    $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD']);

    ReflectionInjector::createBySettings(new LocalSettings(realpath(__DIR__.'/../app/settings')))
        ->invokeFunction(
            function (Injector $injector, EventProvider $eventProvider) {
                $injector->loadServices(
                    [
                        HttpRequest::class => new CgiRequest(),
                        HttpResponse::class => new HttpResponse(),
                    ]
                );
                $eventProvider->trigger(
                    $injector->createObject(HttpExchangeEvent::class)
                );
            }
        )
    ;
} catch (Throwable $e) {
    var_dump($e);
}
