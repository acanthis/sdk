<?php

namespace Eds\Common\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\UuidValidator;

class ClientIdElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('clientId')
            ->addFilter(new TrimFilter())
            ->addValidator((new UuidValidator()))
        ;
    }
}
