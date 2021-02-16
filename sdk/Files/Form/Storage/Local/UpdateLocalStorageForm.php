<?php

namespace Nrg\Files\Form\Storage\Local;

use Nrg\Files\Form\Storage\UpdateStorageForm;
use Nrg\Files\Form\Storage\Local\Element\RootElement;
use Nrg\Files\UseCase\Storage\IsUniqueName;
use Nrg\I18n\Abstraction\Translator;

/**
 * Class UpdateLocalStorageForm
 */
class UpdateLocalStorageForm extends UpdateStorageForm
{
    public function __construct(Translator $translator, IsUniqueName $isUniqueName)
    {
        parent::__construct($translator, $isUniqueName);

        $this->addElement(new RootElement());
    }
}