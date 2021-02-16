<?php

namespace Nrg\Http\Value;

use InvalidArgumentException;
use Nrg\Utility\ArrayHelper;

class Url
{
    private ?string $scheme;

    private ?string $user;

    private ?string $password;

    private ?string  $host;

    private ?int $port;

    private ?string  $basePath;

    private ?string $path;

    private ?string $query;

    private ?string $fragment;

    private ?string $href;

    private ?string $hrefBeforeSearch;

    public function __construct(string $url, ?string $basePath = null)
    {
        $partials = parse_url($url);

        $this->scheme = isset($partials['scheme']) ? $partials['scheme'] : null;
        $this->user = isset($partials['user']) ? $partials['user'] : null;
        $this->password = isset($partials['pass']) ? $partials['pass'] : null;
        $this->host = isset($partials['host']) ? $partials['host'] : null;
        $this->port = isset($partials['port']) ? (int) $partials['port'] : null;
        $this->query = isset($partials['query']) ? $partials['query'] : null;
        $this->fragment = isset($partials['fragment']) ? $partials['fragment'] : null;

        $this->initPath($partials['path'] ?? null, $basePath);
    }

    public function __toString()
    {
        if (null !== $this->href) {
            return $this->href;
        }

        $this->href = $this->getHrefBeforeSearch();

        if (null !== $this->query) {
            $this->href .= '?'.$this->query;
        }
        if (null !== $this->fragment) {
            $this->href .= '#'.$this->fragment;
        }

        return $this->href;
    }

    public function getScheme(): ?string
    {
        return $this->scheme;
    }

    public function setScheme(string $scheme): Url
    {
        $this->scheme = $scheme;
        $this->reset();

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): Url
    {
        $this->user = $user;
        $this->reset();

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): Url
    {
        $this->password = $password;
        $this->reset();

        return $this;
    }

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function setHost(string $host): Url
    {
        $this->host = $host;
        $this->reset();

        return $this;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setPort(int $port): Url
    {
        $this->port = $port;
        $this->reset();

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): Url
    {
        $this->path = '/'.trim($path, '/');
        $this->reset();

        return $this;
    }

    public function makeClone(): Url
    {
        return new static($this, $this->basePath);
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function setQuery(string $query): Url
    {
        $this->query = $query;
        $this->reset();

        return $this;
    }

    public function getQueryParams(): array
    {
        if (null === $this->query) {
            return [];
        }

        parse_str($this->query, $params);

        return $params;
    }

    public function setQueryParams(array $params): Url
    {
        $this->query = empty($params) ? null : http_build_query($params);
        $this->reset();

        return $this;
    }

    /**
     * @param null $default
     *
     * @return null|mixed
     */
    public function getQueryParam(string $name, $default = null)
    {
        $params = $this->getQueryParams();

        return $params[$name] ?? $default;
    }

    public function getFragment(): ?string
    {
        return $this->fragment;
    }

    public function setFragment(string $fragment): Url
    {
        $this->fragment = $fragment;
        $this->reset();

        return $this;
    }

    public function getValue(): string
    {
        return (string) $this;
    }

    public function contains(Url $url): bool
    {
        return $this->getHrefBeforeSearch() === $url->getHrefBeforeSearch() &&
            ArrayHelper::contains($url->getQueryParams(), $this->getQueryParams()) &&
            $this->getFragment() === $url->getFragment();
    }

    public function getHrefBeforeSearch(): ?string
    {
        if (null !== $this->hrefBeforeSearch) {
            return $this->hrefBeforeSearch;
        }

        $this->hrefBeforeSearch = '';

        if (null !== $this->scheme) {
            $this->hrefBeforeSearch .= $this->scheme.'://';
        }
        if (null !== $this->user) {
            $this->hrefBeforeSearch .= $this->user;
        }
        if (null !== $this->password && null !== $this->user) {
            $this->hrefBeforeSearch .= ':'.$this->password;
        }
        if (null !== $this->host) {
            $this->hrefBeforeSearch .= null === $this->user ? $this->host : '@'.$this->host;
        }
        if (null !== $this->port && null !== $this->host) {
            $this->hrefBeforeSearch .= ':'.$this->port;
        }
        $this->hrefBeforeSearch .= rtrim($this->basePath, '/');
        $this->hrefBeforeSearch .= $this->path;

        return $this->hrefBeforeSearch;
    }

    private function reset(): void
    {
        $this->href = null;
        $this->hrefBeforeSearch = null;
    }

    private function initPath(?string $path, ?string $basePath): void
    {
        $path = null === $path ? '/' : '/'.trim($path, '/');
        $basePath = $basePath ?? trim($basePath, '/');

        if (empty($basePath)) {
            $this->path = $path;

            return;
        }

        $this->basePath = '/'.$basePath;
        if (substr($path, 0, strlen($this->basePath)) !== $this->basePath) {
            throw new InvalidArgumentException('Invalid basePath, it must be part of the path');
        }

        $path = substr($path, strlen($this->basePath));
        $this->path = empty($path) ? '/' : $path;
    }
}
