<?php

namespace Nrg\Data\Form;

use Nrg\Data\Form\Element\LimitElement;
use Nrg\Data\Form\Element\OffsetElement;
use Nrg\Data\Form\Element\OrderByElement;
use Nrg\Form\Form;

class ListForm extends Form
{
    private OrderByElement $orderByElement;
    private FilterForm $filterForm;

    public function __construct()
    {
        $this->orderByElement = new OrderByElement();
        $this->filterForm = new FilterForm();
        $this
            ->addElement(new LimitElement())
            ->addElement(new OffsetElement())
            ->addElement($this->orderByElement)
            ->addElement($this->filterForm)
        ;
    }

    public function setSortableFields(array $allowedFields): ListForm
    {
        $this->orderByElement->setFilterableFields($allowedFields);

        return $this;
    }

    public function addConditionForm(Form $form): ListForm
    {
        $this->filterForm->addConditionForm($form);

        return $this;
    }
}
