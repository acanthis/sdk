<?php

namespace Nrg\Auth\Action;

use Nrg\Auth\Form\Element\TokenElement;
use Nrg\Auth\UseCase\RefreshSignin;
use Nrg\Auth\Value\TokenType;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class RefreshSigninAction
{
    private const ERROR_TOKEN_IS_REQUIRED = 'auth_validation_tokenIsRequired';

    private TokenElement $element;
    private RefreshSignin $refreshSignin;

    public function __construct(
        TokenElement $element,
        RefreshSignin $refreshSignin
    ) {
        $this->element = $element;
        $this->refreshSignin = $refreshSignin;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $value = $event->getRequest()->getBodyParam('token');

        if (null === $value) {
            throw new ValidationException(self::ERROR_TOKEN_IS_REQUIRED);
        }

        $this->element
            ->setValue($value)
            ->setTokenType(TokenType::REFRESH);

        if (!$this->element->isValid()) {
            throw new ValidationException($this->element->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::CREATED)
            ->setBody($this->refreshSignin->execute($this->element->getValue()));
    }
}
