<?php

namespace Eds\Contractor\Form\PackageDocFile;

use Nrg\Form\Element\UuidRequiredElement;
use Nrg\Form\Form;

class PackageDocFileDeleteForm extends Form
{
    public function __construct()
    {
        $this
            ->addElement(new UuidRequiredElement())
        ;
    }
}
