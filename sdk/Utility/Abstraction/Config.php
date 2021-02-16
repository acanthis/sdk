<?php

namespace Nrg\Utility\Abstraction;

use JsonSerializable;

interface Config extends JsonSerializable
{
    public const MODE_KEY_NAME = 'mode';
    public const DEVELOPMENT_MODE = 'development';
    public const PRODUCTION_MODE = 'production';

    public function has(string $key): bool;

    /** @return mixed */
    public function get(string $key, $defaultValue = null);

    public function set(string $key, $value): Config;

    public function load(array $data): Config;

    public function asArray(): array;

    public function getPublic(): array;

    public function getMode(): string;

    public function isDevelopmentMode(): bool;

    public function isProductionMode(): bool;
}
