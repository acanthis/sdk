<?php

namespace Nrg\Http\Exception;

use Nrg\Http\Value\HttpStatus;

class NotFoundException extends HttpException
{
    public function __construct($message = 'Not Found', ...$args)
    {
        array_shift($args);
        parent::__construct($message, HttpStatus::NOT_FOUND, ...$args);
    }
}
