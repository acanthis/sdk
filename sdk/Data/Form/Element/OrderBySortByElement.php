<?php

namespace Nrg\Data\Form\Element;

use Nrg\Data\Dto\OrderBy;
use Nrg\Form\Element;
use Nrg\Form\Filter\LowerCaseFilter;
use Nrg\Form\Validator\InArrayValidator;

class OrderBySortByElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('sortBy')
            ->addFilter(new LowerCaseFilter())
            ->isRequired()
            ->addValidator(
                (new InArrayValidator())
                    ->setHaystack([
                        OrderBy::SORT_BY_ASC,
                        OrderBy::SORT_BY_DESC,
                    ])
            )
        ;
    }
}
