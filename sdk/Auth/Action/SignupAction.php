<?php

namespace Nrg\Auth\Action;

use Nrg\Auth\Dto\SignupInput;
use Nrg\Auth\Form\SignupForm;
use Nrg\Auth\UseCase\Signup;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class SignupAction
{
    private SignupForm $form;

    private Signup $signup;

    public function __construct(SignupForm $form, Signup $login)
    {
        $this->form = $form;
        $this->signup = $login;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->form->setValue($event->getRequest()->getBodyParams());

        if (!$this->form->isValid()) {
            throw new ValidationException($this->form->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::CREATED)
            ->setBody($this->signup->execute(new SignupInput($this->form->getValue())));
    }
}
