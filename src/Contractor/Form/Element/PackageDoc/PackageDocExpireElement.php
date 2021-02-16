<?php

namespace Eds\Contractor\Form\Element\PackageDoc;

use DateTime;
use Nrg\Form\Element;
use Nrg\Form\Validator\GreaterThanDateTimeValidator;

class PackageDocExpireElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('expire')
            ->addValidator(new GreaterThanDateTimeValidator(new DateTime()))
        ;
    }
}