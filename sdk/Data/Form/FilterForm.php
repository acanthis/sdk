<?php

namespace Nrg\Data\Form;

use Nrg\Data\Form\Element\FilterConditionsElement;
use Nrg\Data\Form\Element\FilterUnionElement;
use Nrg\Form\Form;

class FilterForm extends Form
{
    private FilterConditionsElement $filterConditionsElement;

    public function __construct()
    {
        $this->filterConditionsElement = new FilterConditionsElement();

        $this
            ->setName('filter')
            ->addElement(new FilterUnionElement())
            ->addElement($this->filterConditionsElement)
        ;
    }

    public function addConditionForm(Form $form): FilterForm
    {
        $this->filterConditionsElement->addConditionForm($form);

        return $this;
    }
}
