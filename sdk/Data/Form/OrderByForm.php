<?php

namespace Nrg\Data\Form;

use Nrg\Data\Form\Element\OrderByFieldElement;
use Nrg\Data\Form\Element\OrderBySortByElement;
use Nrg\Form\Form;

class OrderByForm extends Form
{
    private OrderByFieldElement $orderByFieldElement;

    public function __construct()
    {
        $this->orderByFieldElement = new OrderByFieldElement();

        $this
            ->addElement($this->orderByFieldElement)
            ->addElement(new OrderBySortByElement())
        ;
    }

    public function setFilterableFields(array $allowedFields): OrderByForm
    {
        $this->orderByFieldElement->setFilterableFields($allowedFields);

        return $this;
    }
}
