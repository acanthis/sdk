<?php

namespace Nrg\Utility\Abstraction;

interface Settings
{
    public const KEY_SERVICES = 'services';
    public const KEY_EVENTS = 'events';
    public const KEY_ROUTES = 'routes';

    public function getServices(): array;

    public function getEvents(): array;

    public function getRoutes(): array;
}
