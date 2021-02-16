<?php

namespace Nrg\Http\Value;

use JsonSerializable;

class HttpErrorMessage implements JsonSerializable
{
    private HttpStatus $status;

    private $details;

    private $debugInfo;

    public function __construct(HttpStatus $status)
    {
        $this->status = $status;
    }

    public function setReasonPhrase(string $reasonPhrase): HttpErrorMessage
    {
        $this->status->setReasonPhrase($reasonPhrase);

        return $this;
    }

    public function setDetails($details): HttpErrorMessage
    {
        $this->details = $details;

        return $this;
    }

    public function setDebugInfo($debugInfo): HttpErrorMessage
    {
        $this->debugInfo = $debugInfo;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'statusCode' => $this->status->getCode(),
            'reasonPhrase' => $this->status->getReasonPhrase(),
            'details' => $this->details,
            'debugInfo' => $this->debugInfo,
        ];
    }
}
