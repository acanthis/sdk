<?php

namespace Eds\Contractor\Form\Element\PackageDoc;

use Nrg\Form\Element;
use Nrg\Form\Validator\UuidValidator;

class PackageDocIdElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('packageDocId')
            ->addValidator(new UuidValidator())
        ;
    }
}