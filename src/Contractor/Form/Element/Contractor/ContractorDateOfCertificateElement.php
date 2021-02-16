<?php

namespace Eds\Contractor\Form\Element\Contractor;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\DateTimeValidator;

class ContractorDateOfCertificateElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('dateOfCertificate')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(new DateTimeValidator())
        ;
    }
}
