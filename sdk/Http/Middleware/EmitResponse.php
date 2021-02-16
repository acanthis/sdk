<?php

namespace Nrg\Http\Middleware;

use Nrg\Http\Abstraction\ResponseEmitter;
use Nrg\Http\Event\HttpExchangeEvent;
use Throwable;

/**
 * Emits the HTTP response when the HttpExchangeEvent are triggered by observable.
 */
class EmitResponse
{
    private ResponseEmitter $emitResponse;

    public function __construct(ResponseEmitter $emitResponse)
    {
        $this->emitResponse = $emitResponse;
    }

    /**
     * Emits the HTTP response when the HttpExchangeEvent are triggered by observable.
     */
    public function onNext(HttpExchangeEvent $event)
    {
        $this->emitResponse->emit($event->getResponse());
    }

    /**
     * Emits the HTTP response when an error occurred while processing the observers.
     */
    public function onError(Throwable $throwable, HttpExchangeEvent $event)
    {
        $this->emitResponse->emit($event->getResponse());
    }
}
