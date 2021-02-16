<?php

namespace Nrg\Http\Abstraction;

use Nrg\Http\Value\HttpResponse;

interface ResponseEmitter
{
    public function emit(HttpResponse $response, bool $terminate = false): void;
}
