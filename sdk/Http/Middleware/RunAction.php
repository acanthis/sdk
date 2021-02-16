<?php

namespace Nrg\Http\Middleware;

use Nrg\Http\Abstraction\RouteProvider;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\NotFoundException;
use ReflectionException;
use Throwable;

/**
 * Manages the launch of the corresponding routing action when the HttpExchangeEvent are triggered by observable.
 */
class RunAction
{
    private RouteProvider $routeProvider;

    private $actions = [];

    public function __construct(RouteProvider $routeProvider)
    {
        $this->routeProvider = $routeProvider;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->actions = $this->routeProvider->getActions($event->getRequest());
        foreach ($this->actions as $action) {
            if (method_exists($action, 'onNext')) {
                $action->onNext($event);
            }
        }
    }

    public function onError(Throwable $throwable, HttpExchangeEvent $event)
    {
        foreach ($this->actions as $action) {
            if (method_exists($action, 'onError')) {
                $action->onError($throwable, $event);
            }
        }
    }

    public function onComplete()
    {
        foreach ($this->actions as $action) {
            if (method_exists($action, 'onComplete')) {
                $action->onComplete();
            }
        }
    }
}
