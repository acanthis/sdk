<?php

namespace Nrg\Auth\Form;

use Nrg\Auth\Form\Element\EmailElement;
use Nrg\Auth\Form\Element\PasswordElement;
use Nrg\Auth\Form\Validator\CredentialValidator;
use Nrg\Form\Form;
use Nrg\I18n\Abstraction\Translator;

class ResetPasswordForm extends Form
{
    public function __construct(
        Translator $translator,
        EmailElement $emailElement,
        PasswordElement $passwordElement,
        CredentialValidator $credentialValidator
    ) {
        parent::__construct($translator);

        $this
            ->addElement($emailElement)
            ->addElement(
                $passwordElement
                    ->addValidator($credentialValidator)
            )
        ;
    }
}
