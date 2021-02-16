<?php

namespace Nrg\Http\Exception;

use Nrg\Http\Value\HttpStatus;

class ValidationException extends HttpException
{
    private $details;

    public function __construct($details, $message = 'Unprocessable Entity', ...$args)
    {
        array_shift($args);
        parent::__construct($message, HttpStatus::UNPROCESSABLE_ENTITY, ...$args);
        $this->details = $details;
    }

    public function getDetails()
    {
        return $this->details;
    }
}
