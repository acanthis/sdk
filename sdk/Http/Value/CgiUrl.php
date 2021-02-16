<?php

namespace Nrg\Http\Value;

/**
 * Url composed of CGI environment data.
 */
class CgiUrl extends Url
{
    public function __construct()
    {
        parent::__construct(
            $this->createCurrentUrl(),
            $this->createBasePath()
        );
    }

    private function createCurrentUrl(): string
    {
        return sprintf(
            '%s%s%s',
            $this->createProtocol(),
            $_SERVER['HTTP_HOST'],
            $_SERVER['REQUEST_URI']
        );
    }

    private function createBasePath(): ?string
    {
        $basePath = trim(str_replace('\\', '/', dirname($_SERVER['PHP_SELF'])), '/');

        return empty($basePath) ? null : $basePath;
    }

    /**
     * Returns Url protocol for current environment.
     */
    private function createProtocol(): string
    {
        return (!empty($_SERVER['HTTPS']) && 'off' !== $_SERVER['HTTPS'] || 443 === $_SERVER['SERVER_PORT']) ?
            'https://' : 'http://';
    }
}
