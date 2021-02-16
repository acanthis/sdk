<?php

namespace Nrg\Data\Form\Element;

use Nrg\Data\Dto\Filter;
use Nrg\Form\Element;
use Nrg\Form\Filter\LowerCaseFilter;
use Nrg\Form\Validator\InArrayValidator;

class FilterUnionElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('union')
            ->addFilter(new LowerCaseFilter())
            ->isRequired()
            ->addValidator(
                (new InArrayValidator())
                    ->setHaystack([
                        Filter::UNION_AND,
                        Filter::UNION_OR,
                    ])
            )
        ;
    }
}
