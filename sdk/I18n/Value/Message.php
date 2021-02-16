<?php

namespace Nrg\I18n\Value;

use JsonSerializable;

class Message implements JsonSerializable
{
    private string $text;

    private array $params = [];

    public function __construct(string $text, array $params = [])
    {
        $this->text = $text;
        $this->params = $params;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function jsonSerialize()
    {
        return [
            'text' => $this->getText(),
            'params' => $this->getParams(),
        ];
    }
}
