<?php

namespace Nrg\Files\Form\Storage;

use Nrg\Files\Form\Storage\Element\DescriptionElement;
use Nrg\Files\Form\Storage\Element\NameElement;
use Nrg\Files\Form\Storage\Validator\UniqueNameValidator;
use Nrg\Files\UseCase\Storage\IsUniqueName;
use Nrg\Form\Form;
use Nrg\Form\Validator\IsRequiredValidator;
use Nrg\I18n\Abstraction\Translator;

class CreateStorageForm extends Form
{
    public function __construct(Translator $translator, IsUniqueName $isUniqueName)
    {
        parent::__construct($translator);

        $this
            ->addElement(
                (new NameElement())
                    ->addValidator(new IsRequiredValidator())
                    ->addValidator(new UniqueNameValidator($isUniqueName))
            )
            ->addElement(new DescriptionElement());
    }
}
