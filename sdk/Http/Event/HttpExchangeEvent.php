<?php

namespace Nrg\Http\Event;

use Nrg\Http\Value\HttpRequest;
use Nrg\Http\Value\HttpResponse;

/**
 * HTTP message exchange event
 * It is a container for the HTTP request and HTTP response.
 */
class HttpExchangeEvent
{
    private HttpRequest $request;

    private HttpResponse $response;

    public function __construct(HttpRequest $request, HttpResponse $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
