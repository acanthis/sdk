<?php

namespace Nrg\Data\Form\Element;

use Nrg\Data\Form\OrderByForm;
use Nrg\Form\Element;
use Nrg\Form\Validator\ArrayFormValidator;

class OrderByElement extends Element
{
    private OrderByForm $orderByForm;

    public function __construct()
    {
        $this->orderByForm = new OrderByForm();

        $this->setName('orderBy');
        $this->addValidator(
            (new ArrayFormValidator())
                ->addForm($this->orderByForm->setName('orderBy'))
        );
    }

    public function setFilterableFields(array $allowedFields): OrderByElement
    {
        $this->orderByForm->setFilterableFields($allowedFields);

        return $this;
    }
}
