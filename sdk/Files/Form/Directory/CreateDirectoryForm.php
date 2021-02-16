<?php

namespace Nrg\Files\Form\Directory;

use Nrg\Files\Form\File\Element\PathElement;
use Nrg\Files\Form\File\Validator\UniquePath;
use Nrg\Files\UseCase\File\IsUniquePath;
use Nrg\Form\Form;
use Nrg\I18n\Abstraction\Translator;

class CreateDirectoryForm extends Form
{
    public function __construct(Translator $translator, IsUniquePath $isUniqueName)
    {
        parent::__construct($translator);

        $this->addElement(
            (new PathElement())
                ->addValidator(new UniquePath($isUniqueName))
        );
    }
}