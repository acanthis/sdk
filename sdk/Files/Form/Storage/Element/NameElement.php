<?php

namespace Nrg\Files\Form\Storage\Element;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthValidator;
use Nrg\Form\Validator\IsStringValidator;

class NameElement extends Element
{
    public function __construct()
    {
        parent::__construct('name');

        $this
            ->addFilter(new TrimFilter())
            ->addValidator(new IsStringValidator())
            ->addValidator(
                (new LengthValidator())
                    ->setMin(1)
                    ->setMax(50)
            );
    }
}