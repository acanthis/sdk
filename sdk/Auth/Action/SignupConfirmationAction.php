<?php

namespace Nrg\Auth\Action;

use Nrg\Auth\Form\Element\TokenElement;
use Nrg\Auth\UseCase\SignupConfirmation;
use Nrg\Auth\Value\TokenType;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class SignupConfirmationAction
{
    private const ERROR_TOKEN_IS_REQUIRED = 'auth_validation_tokenIsRequired';

    private TokenElement $element;
    private SignupConfirmation $signupConfirmation;

    public function __construct(
        TokenElement $element,
        SignupConfirmation $signupConfirmation
    ) {
        $this->element = $element;
        $this->signupConfirmation = $signupConfirmation;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $value = $event->getRequest()->getBodyParam('token');

        if (null === $value) {
            throw new ValidationException(self::ERROR_TOKEN_IS_REQUIRED);
        }

        $this->element
            ->setValue($value)
            ->setTokenType(TokenType::SIGNUP_CONFIRMATION);

        if (!$this->element->isValid()) {
            throw new ValidationException($this->element->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::CREATED)
            ->setBody($this->signupConfirmation->execute($this->element->getValue()));
    }
}
