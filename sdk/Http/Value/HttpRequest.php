<?php

namespace Nrg\Http\Value;

class HttpRequest
{
    use HttpMessage;

    private Url $url;

    private string $method;

    private array $cookies = [];

    private array $queryParams = [];

    /** @var null|mixed */
    private $bodyParams;

    private array $uploadedFiles = [];

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function setUrl(Url $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getCookies(): array
    {
        return $this->cookies;
    }

    public function setCookies(array $cookies): self
    {
        $this->cookies = $cookies;

        return $this;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getQueryParam(string $name, string $default = null): ?string
    {
        return $this->queryParams[$name] ?? $default;
    }

    public function setQueryParams(array $queryParams): self
    {
        $this->queryParams = $queryParams;

        return $this;
    }

    /** @return mixed */
    public function getBodyParams()
    {
        return $this->bodyParams;
    }

    public function setBodyParams($bodyParams): self
    {
        $this->bodyParams = $bodyParams;

        return $this;
    }

    public function getBodyParam($name, $default = null): ?string
    {
        return $this->bodyParams[$name] ?? $default;
    }

    public function setBodyParam(string $name, $value): self
    {
        $this->bodyParams[$name] = $value;

        return $this;
    }

    /** @return UploadedFile[] */
    public function getUploadedFiles(): array
    {
        return $this->uploadedFiles;
    }

    public function getUploadedFile(string $name): ?UploadedFile
    {
        return $this->uploadedFiles[$name] ?? null;
    }

    /** @param UploadedFile[] $uploadedFiles */
    public function setUploadedFiles(array $uploadedFiles): self
    {
        $this->uploadedFiles = $uploadedFiles;

        return $this;
    }
}
