<?php

namespace Nrg\Data\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Validator\InArrayValidator;
use Nrg\Form\Validator\StringValidator;

class ConditionFieldElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('field')
            ->isRequired()
            ->addValidator(new StringValidator())
        ;
    }

    public function setFilterableFields(array $fields): ConditionFieldElement
    {
        $this->addValidator(
            (new InArrayValidator())
                ->setHaystack($fields)
                ->setStrict(true)
        );

        return $this;
    }
}
