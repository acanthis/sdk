<?php

namespace Eds\CustomFields\Form\Element\Attribute;

use Nrg\Form\Element;
use Nrg\Form\Validator\LengthGreaterOrEqualThanValidator;
use Nrg\Form\Validator\LengthLessOrEqualThanValidator;
use Nrg\Form\Validator\StringValidator;
use Nrg\Utility\PopulateProps;

class CustomFieldTextElement extends Element
{
    use PopulateProps;

    public function __construct(array $attributes)
    {
        $this->populateProps($attributes);
        $this->addValidator(new StringValidator());
    }

    private function setMaxLength(int $value)
    {
        $this->addValidator(
            (new LengthLessOrEqualThanValidator())
                ->setLength($value)
        );
    }

    private function setMinLength(int $value)
    {
        $this->addValidator(
            (new LengthGreaterOrEqualThanValidator())
                ->setLength($value)
        );
    }
}