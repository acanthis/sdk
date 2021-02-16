<?php

namespace Nrg\Auth\Form;

use Nrg\Auth\Form\Element\EmailElement;
use Nrg\Auth\Form\Element\UuidElement;
use Nrg\Form\Form;
use Nrg\I18n\Abstraction\Translator;

class UserUpdateForm extends Form
{
    public function __construct(Translator $translator, EmailElement $emailElement, UuidElement $uuidElement)
    {
        parent::__construct($translator);

        $this
            ->addElement($uuidElement)
            ->addElement($emailElement)
        ;
    }
}
