<?php

namespace Nrg\Data\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Form;
use Nrg\Form\Validator\ArrayFormValidator;

class FilterConditionsElement extends Element
{
    private ArrayFormValidator $arrayFormValidator;

    public function __construct()
    {
        $this->arrayFormValidator = new ArrayFormValidator();

        $this
            ->setName('conditions')
            ->addValidator($this->arrayFormValidator)
        ;
    }

    public function addConditionForm(Form $form): FilterConditionsElement
    {
        $this->arrayFormValidator->addForm($form);

        return $this;
    }
}
