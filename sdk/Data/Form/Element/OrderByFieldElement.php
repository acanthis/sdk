<?php

namespace Nrg\Data\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Validator\InArrayValidator;
use Nrg\Form\Validator\StringValidator;

class OrderByFieldElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('field')
            ->isRequired()
            ->addValidator(new StringValidator())
        ;
    }

    public function setFilterableFields(array $allowedFields): OrderByFieldElement
    {
        $this->addValidator(
            (new InArrayValidator())
                ->setHaystack($allowedFields)
                ->setStrict(true)
        );

        return $this;
    }
}
