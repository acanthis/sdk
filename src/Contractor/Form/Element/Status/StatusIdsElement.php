<?php

namespace Eds\Contractor\Form\Element\Status;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\ArrayValidator;
use Nrg\Form\Validator\UuidValidator;

class StatusIdsElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('statusIds')
            ->addValidator(
                (new ArrayValidator())
                    ->addFilter(new TrimFilter())
                    ->addValidator(new UuidValidator())
            )
        ;
    }
}
