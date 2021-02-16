<?php

namespace Nrg\Http\Exception;

use Nrg\Http\Value\HttpStatus;

class UnauthorizedException extends HttpException
{
    public function __construct($message = 'Unauthorized', ...$args)
    {
        array_shift($args);
        parent::__construct($message, HttpStatus::UNAUTHORIZED, ...$args);
    }
}
