<?php

namespace Nrg\Http\Middleware;

use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Value\HttpResponse;
use Throwable;

class SerializeJsonResponse
{
    public function onNext(HttpExchangeEvent $event)
    {
        $this->execute($event->getResponse());
    }

    public function onError(Throwable $throwable, HttpExchangeEvent $event)
    {
        $this->execute($event->getResponse());
    }

    private function execute(HttpResponse $response)
    {
        if ($response->containsInHeader('Content-Type', 'application/json')) {
            $response->setHeader('Content-Type', 'application/json; charset=utf-8');
            $response->setBody(
                json_encode($response->getBody(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            );
        }
    }
}
