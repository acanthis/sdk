<?php

namespace Nrg\Http\Service;

use Nrg\Di\Abstraction\Injector;
use Nrg\Http\Abstraction\RouteProvider;
use Nrg\Http\Exception\NotFoundException;
use Nrg\Http\Value\HttpRequest;
use Nrg\Utility\Abstraction\Settings;

class HttpRouteProvider implements RouteProvider
{
    private Injector $injector;

    private array $routes = [];

    public function __construct(Injector $injector, Settings $settings = null)
    {
        $this->injector = $injector;

        if (null !== $settings) {
            foreach ($settings->getRoutes() as $route => $action) {
                $this->when($route, $action);
            }
        }
    }

    public function when(string $route, $action): RouteProvider
    {
        $this->routes[$route] = $action;

        return $this;
    }

    public function getActions(HttpRequest $request): array
    {
        $route = $request->getUrl()->getPath();
        $method = $request->getMethod();
        $actions = $this->routes["{$method}:{$route}"] ?? $this->routes[$route] ?? null;

        if (null === $actions) {
            throw new NotFoundException();
        }

        if (!is_array($actions)) {
            $actions = [$actions];
        }

        foreach ($actions as $index => $action) {
            $actions[$index] = is_object($action) ?
                $action :
                $this->injector->createObject($action);
        }

        return $actions;
    }
}
