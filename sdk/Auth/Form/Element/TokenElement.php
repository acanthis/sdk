<?php

namespace Nrg\Auth\Form\Element;

use Nrg\Auth\Form\Validator\TokenValidator;
use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\StringValidator;

class TokenElement extends Element
{
    private TokenValidator $tokenValidator;

    public function __construct(TokenValidator $tokenValidator)
    {
        $this->tokenValidator = $tokenValidator;
        $this
            ->setName('token')
            ->isRequired()
            ->addFilter(new TrimFilter())
            ->addValidator(new StringValidator())
            ->addValidator($tokenValidator);
    }

    public function setTokenType(int $tokenType): TokenElement
    {
        $this->tokenValidator->setTokenType($tokenType);

        return $this;
    }
}