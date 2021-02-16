<?php

namespace Nrg\Auth\Action;

use Nrg\Auth\Dto\SigninInput;
use Nrg\Auth\Form\SigninForm;
use Nrg\Auth\UseCase\Signin;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class ResetPasswordAction
{
    private SigninForm $form;

    private Signin $login;

    public function __construct(SigninForm $form, Signin $login)
    {
        $this->form = $form;
        $this->login = $login;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->form->setValue($event->getRequest()->getBodyParams());

        if ($this->form->isValid()) {
            throw new ValidationException($this->form->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::CREATED)
            ->setBody($this->login->execute(new SigninInput($this->form->getValue())))
        ;
    }
}
