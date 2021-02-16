<?php

namespace Eds\Contractor\Form\Element\Contractor;

use Nrg\Form\Element;
use Nrg\Form\Validator\BooleanValidator;

class ContractorIsArchiveElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('isArchive')
            ->addValidator(new BooleanValidator())
        ;
    }
}
