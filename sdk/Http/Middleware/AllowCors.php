<?php

namespace Nrg\Http\Middleware;

use Nrg\Http\Abstraction\ResponseEmitter;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Value\HttpStatus;

class AllowCors
{
    private const DEFAULT_MAX_AGE = 86400;
    private const DEFAULT_METHODS = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'];

    private ResponseEmitter $emitResponse;

    private int $maxAge;

    private array $methods;

    private bool $isProductionMode = false; // todo: read from config

    public function __construct(
        ResponseEmitter $emitResponse,
        int $maxAge = self::DEFAULT_MAX_AGE,
        array $methods = self::DEFAULT_METHODS
    ) {
        $this->emitResponse = $emitResponse;
        $this->maxAge = $maxAge;
        $this->methods = $methods;
    }

    public function onNext(HttpExchangeEvent $event): void
    {
        if ($this->isProductionMode) {
            return;
        }

        $request = $event->getRequest();
        $response = $event->getResponse();

        if (isset($_SERVER['HTTP_ORIGIN'])) {
            $response
                ->setHeader('Access-Control-Allow-Origin', $_SERVER['HTTP_ORIGIN'])
                ->setHeader('Access-Control-Allow-Credentials', 'true')
                ->setHeader('Access-Control-Max-Age', $this->maxAge);
        }

        if ('OPTIONS' === $request->getMethod()) {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                $response->setHeader(
                    'Access-Control-Allow-Methods',
                    implode(',', $this->methods)
                );
            }
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                $response->setHeader(
                    'Access-Control-Allow-Headers',
                    $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']
                );
            }

            $response->setStatusCode(HttpStatus::OK);
            $this->emitResponse->emit($response, true);
        }
    }
}
