<?php

namespace Nrg\Http\Middleware;

use Nrg\Http\Event\HttpExchangeEvent;

class ResponsePayload
{
    public function onNext(HttpExchangeEvent $event)
    {
        $event->getResponse()->setBody([
            'payload' => $event->getResponse()->getBody()
        ]);
    }
}
