<?php

namespace Eds\Contractor\Form\Element\PackageDocFile;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthStringRangeValidator;
use Nrg\Form\Validator\StringValidator;

class PackageDocFileNameElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('originalName')
            ->addFilter(new TrimFilter())
            ->addValidator(new StringValidator())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(1)
                    ->setMaxLength(200)
            )
        ;
    }
}
