<?php

namespace Eds\Common\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\UuidValidator;

class CreatorIdElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('creatorId')
            ->addFilter(new TrimFilter())
            ->addValidator((new UuidValidator()))
        ;
    }
}
