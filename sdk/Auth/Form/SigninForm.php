<?php

namespace Nrg\Auth\Form;

use Nrg\Auth\Form\Element\EmailElement;
use Nrg\Auth\Form\Element\PasswordElement;
use Nrg\Auth\Form\Validator\CredentialValidator;
use Nrg\Form\Form;

class SigninForm extends Form
{
    public function __construct(
        EmailElement $emailElement,
        PasswordElement $passwordElement,
        CredentialValidator $credentialValidator
    ) {

        $this
            ->addElement($emailElement)
            ->addElement(
                $passwordElement
                    ->addValidator($credentialValidator)
            )
        ;
    }
}
