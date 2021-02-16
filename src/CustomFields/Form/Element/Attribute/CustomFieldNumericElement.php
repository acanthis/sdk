<?php

namespace Eds\CustomFields\Form\Element\Attribute;

use Nrg\Form\Element;
use Nrg\Form\Validator\LengthGreaterOrEqualThanValidator;
use Nrg\Form\Validator\LengthLessOrEqualThanValidator;
use Nrg\Form\Validator\StringValidator;
use Nrg\Utility\PopulateProps;

class CustomFieldNumericElement extends Element
{
    use PopulateProps;

    public function __construct(array $attributes)
    {
        $this->populateProps($attributes);
        $this->addValidator(new StringValidator());
    }

    private function setMax($value)
    {
        $this->addValidator(
            (new LengthLessOrEqualThanValidator())
                ->setLength($value)
        );
    }

    private function setMin($value)
    {
        $this->addValidator(
            (new LengthGreaterOrEqualThanValidator())
                ->setLength($value)
        );
    }
}