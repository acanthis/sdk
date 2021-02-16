<?php

namespace Eds\Contractor\Form\PackageDocFile;

use Eds\Contractor\Form\Element\PackageDocFile\PackageDocFileNameElement;
use Nrg\Form\Element\UuidRequiredElement;
use Nrg\Form\Form;

class PackageDocFileUpdateForm extends Form
{
    public function __construct()
    {
        $this
            ->addElement(new UuidRequiredElement())
            ->addElement(
                (new PackageDocFileNameElement())
                    ->isRequired()
            )
        ;
    }
}
