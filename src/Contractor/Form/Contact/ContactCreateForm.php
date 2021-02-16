<?php

namespace Eds\Contractor\Form\Contact;

use Eds\Common\Form\Element\CreatorIdElement;
use Eds\Common\Form\Element\EmailElement;
use Eds\Common\Form\Element\IsDefaultElement;
use Eds\Common\Form\Element\NoteElement;
use Eds\Common\Form\Element\PhoneElement;
use Eds\Contractor\Form\Element\Contact\ContactNameElement;
use Eds\Contractor\Form\Element\Contact\ContactPostElement;
use Eds\Contractor\Form\Element\Contractor\ContractorIdElement;
use Eds\Contractor\Form\Validator\ContractorExistValidator;
use Eds\Contractor\Persistence\Abstraction\Repository\ContractorRepositoryInterface;
use Nrg\Form\Form;

class
ContactCreateForm extends Form
{
    public function __construct(ContractorRepositoryInterface $contractorRepository)
    {
        $this
            ->addElement(
                (new ContractorIdElement())
                    ->isRequired()
                    ->addValidator(new ContractorExistValidator($contractorRepository))
            )
            ->addElement(
                (new CreatorIdElement())
                    ->isRequired()
            )
            ->addElement(
                (new ContactNameElement())
                    ->isRequired()
            )
            ->addElement(
                (new IsDefaultElement())
                    ->isRequired()
            )
            ->addElement(new ContactPostElement())
            ->addElement(new PhoneElement())
            ->addElement(new EmailElement())
            ->addElement(new NoteElement())
        ;
    }
}
