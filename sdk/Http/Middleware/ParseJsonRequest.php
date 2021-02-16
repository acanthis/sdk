<?php

namespace Nrg\Http\Middleware;

use Nrg\Http\Event\HttpExchangeEvent;

class ParseJsonRequest
{
    /**
     * Handles JSON request
     * Sets request body params from decoded request body.
     */
    public function onNext(HttpExchangeEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        //TODO : add checking json error
        $bodyParams = json_decode($request->getBody(), true) ?? [];
        //if (json_last_error())
        $request->setBodyParams($bodyParams + $request->getBodyParams());
        $response->setHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
