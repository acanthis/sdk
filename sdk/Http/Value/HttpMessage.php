<?php

namespace Nrg\Http\Value;

trait HttpMessage
{
    private string $protocolVersion = '1.1';

    private array $headers = [];

    private array $headerOriginalNames = [];

    /** @var null|mixed */
    private $body;

    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }

    public function setProtocolVersion(string $version): self
    {
        $this->protocolVersion = $version;

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function hasHeader($name): bool
    {
        return array_key_exists(strtolower($name), $this->headerOriginalNames);
    }

    public function getHeader(string $name): array
    {
        if (!$this->hasHeader($name)) {
            return [];
        }

        $originalName = $this->headerOriginalNames[strtolower($name)];

        return $this->headers[$originalName];
    }

    /**
     * Returns values separated by comma.
     */
    public function getHeaderLine(string $name): string
    {
        $header = $this->getHeader($name);

        return empty($header) ? '' : implode(',', $header);
    }

    /** @param array|string $value */
    public function setHeader(string $name, $value): self
    {
        $this->unsetHeader($name);

        if (!is_array($value)) {
            $value = [(string) $value];
        }
        $this->headerOriginalNames[strtolower($name)] = $name;
        $this->headers[$name] = $value;

        return $this;
    }

    public function setHeaders(array $headers): self
    {
        foreach ($headers as $name => $value) {
            $this->setHeader($name, $value);
        }

        return $this;
    }

    /** @param array|string $value */
    public function setAddedHeader(string $name, $value): self
    {
        if ($this->hasHeader($name)) {
            if (!is_array($value)) {
                $value = [$value];
            }
            $this->setHeader($name, array_merge($this->getHeader($name), $value));
        } else {
            $this->setHeader($name, $value);
        }

        return $this;
    }

    public function unsetHeader(string $name): self
    {
        if ($this->hasHeader($name)) {
            $lowCaseName = strtolower($name);
            $originalName = $this->headerOriginalNames[$lowCaseName];
            unset($this->headers[$originalName], $this->headerOriginalNames[$lowCaseName]);
        }

        return $this;
    }

    public function containsInHeader(string $name, string $needle): bool
    {
        foreach ($this->getHeader($name) as $value) {
            if (false !== strpos($value, $needle)) {
                return true;
            }
        }

        return false;
    }

    /** @return null|mixed */
    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body): self
    {
        $this->body = $body;

        return $this;
    }
}
