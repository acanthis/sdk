<?php

namespace Nrg\Http\Value;

class HttpResponse
{
    use HttpMessage;

    private HttpStatus $status;

    public function getStatus(): HttpStatus
    {
        return $this->status ?? new HttpStatus(HttpStatus::OK);
    }

    public function setStatus(HttpStatus $status): HttpResponse
    {
        $this->status = $status;

        return $this;
    }

    public function setStatusCode(int $code, string $reasonPhrase = null): HttpResponse
    {
        $this->setStatus(new HttpStatus($code, $reasonPhrase));

        return $this;
    }
}
