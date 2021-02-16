<?php

namespace Nrg\Files\Form\Hyperlink;

use Nrg\Files\Form\File\Element\PathElement;
use Nrg\Files\Form\File\Validator\UniquePath;
use Nrg\Files\Form\Hyperlink\Element\UrlElement;
use Nrg\Files\UseCase\File\IsUniquePath;
use Nrg\Form\Form;
use Nrg\Form\Validator\IsRequiredValidator;
use Nrg\I18n\Abstraction\Translator;

class CreateHyperlinkForm extends Form
{
    public function __construct(Translator $translator, IsUniquePath $isUniquePath)
    {
        parent::__construct($translator);

        $this
            ->addElement(
                (new PathElement())
                    ->addValidator(new IsRequiredValidator())
                    ->addValidator(new UniquePath($isUniquePath))
            )
            ->addElement(
                (new UrlElement())
                    ->addValidator(new IsRequiredValidator())
            );
    }
}