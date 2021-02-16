<?php

namespace Nrg\Auth\Form;

use Nrg\Auth\Form\Element\EmailElement;
use Nrg\Auth\Form\Element\PasswordElement;
use Nrg\Auth\Form\Validator\UniqueEmailValidator;
use Nrg\Form\Form;

class SignupForm extends Form
{
    public function __construct(UniqueEmailValidator $uniqueEmailValidator)
    {
        $this
            ->addElement(
                (new EmailElement())
                    ->addValidator($uniqueEmailValidator)
            )
            ->addElement(new PasswordElement());
    }
}
