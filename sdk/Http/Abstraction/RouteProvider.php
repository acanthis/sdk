<?php

namespace Nrg\Http\Abstraction;

use Nrg\Http\Value\HttpRequest;

interface RouteProvider
{
    public function when(string $route, $action): RouteProvider;

    public function getActions(HttpRequest $request): array;
}
