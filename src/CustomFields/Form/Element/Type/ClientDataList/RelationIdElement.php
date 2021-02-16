<?php

namespace Eds\CustomFields\Form\Element\Type\ClientDataList;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\InArrayValidator;
use Nrg\Form\Validator\UuidValidator;

class RelationIdElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('relationId')
            ->addFilter(new TrimFilter())
            ->addValidator(new UuidValidator())
        ;
    }
}
