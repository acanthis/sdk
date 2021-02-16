<?php

namespace Eds\Contractor\Form\Contractor;

use Eds\Contractor\Form\Element\Contractor\ContractorIsArchiveElement;
use Nrg\Form\Element\UuidRequiredElement;
use Nrg\Form\Form;

class ContractorArchiveForm extends Form
{
    public function __construct()
    {
        $this
            ->addElement(new UuidRequiredElement())
            ->addElement(
                (new ContractorIsArchiveElement())
                    ->isRequired()
            );
    }
}
