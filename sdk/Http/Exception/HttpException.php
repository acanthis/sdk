<?php

namespace Nrg\Http\Exception;

use Exception;
use Nrg\Http\Value\HttpStatus;

class HttpException extends Exception
{
    private HttpStatus $status;

    public function __construct(...$args)
    {
        parent::__construct(...$args);
        $this->status = new HttpStatus($this->getCode(), $this->getMessage());
    }

    public function getStatus(): HttpStatus
    {
        return $this->status;
    }
}
