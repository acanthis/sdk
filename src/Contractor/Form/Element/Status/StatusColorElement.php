<?php

namespace Eds\Contractor\Form\Element\Status;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthEqualValidator;
use Nrg\Form\Validator\RegexValidator;
use Nrg\Form\Validator\StringValidator;

class StatusColorElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('color')
            ->addFilter(new TrimFilter())
            ->addValidator((new RegexValidator())
                ->setRegex('/#([a-fA-F0-9]{3}){1,2}\b/')
            )
            ->addValidator(
                (new LengthEqualValidator())
                    ->setLengths([4,7])
            )
        ;
    }
}
