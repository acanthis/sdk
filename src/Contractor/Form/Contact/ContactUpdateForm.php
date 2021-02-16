<?php

namespace Eds\Contractor\Form\Contact;

use Eds\Common\Form\Element\EmailElement;
use Eds\Common\Form\Element\IsDefaultElement;
use Eds\Common\Form\Element\NoteElement;
use Eds\Common\Form\Element\PhoneElement;
use Eds\Contractor\Form\Element\Contact\ContactNameElement;
use Eds\Contractor\Form\Element\Contact\ContactPostElement;
use Nrg\Form\Element\UuidRequiredElement;
use Nrg\Form\Form;

class ContactUpdateForm extends Form
{
    public function __construct()
    {
        $this
            ->addElement(new UuidRequiredElement())
            ->addElement((new ContactNameElement())
                ->isRequired()
            )
            ->addElement(new IsDefaultElement())
            ->addElement(new ContactPostElement())
            ->addElement(new PhoneElement())
            ->addElement(new EmailElement())
            ->addElement(new NoteElement())
        ;
    }
}
