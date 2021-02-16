<?php

namespace Eds\Contractor\Form\Element\PackageDoc;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthStringRangeValidator;
use Nrg\Form\Validator\StringValidator;

class PackageDocNameElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('name')
            ->addFilter(new TrimFilter())
            ->addValidator(new StringValidator())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(1)
                    ->setMaxLength(255)
            )
        ;
    }
}
