<?php

namespace Nrg\Utility\Service;

use Nrg\Utility\Abstraction\Config;

class ArrayConfig implements Config
{
    private array $config;

    private array $publicKeys;

    public function __construct(array $config, array $publicKeys = [])
    {
        $this->config = $config;
        $this->publicKeys = $publicKeys;
    }

    public function has(string $key): bool
    {
        return isset($this->config[$key]);
    }

    public function get(string $key, $defaultValue = null)
    {
        return $this->config[$key] ?? $defaultValue;
    }

    public function set(string $key, $value): Config
    {
        $this->config[$key] = $value;

        return $this;
    }

    public function load(array $data): Config
    {
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    public function asArray(): array
    {
        return (array) $this->config;
    }

    public function getPublic(): array
    {
        return array_intersect_key($this->asArray(), array_flip($this->publicKeys));
    }

    public function jsonSerialize()
    {
        return $this->getPublic();
    }

    public function getMode(): string
    {
        return $this->get(self::MODE_KEY_NAME, self::PRODUCTION_MODE);
    }

    public function isDevelopmentMode(): bool
    {
        return self::DEVELOPMENT_MODE === $this->getMode();
    }

    public function isProductionMode(): bool
    {
        return self::PRODUCTION_MODE === $this->getMode();
    }
}
