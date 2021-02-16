<?php

namespace Nrg\Data\Form\Element;

use Nrg\Data\Dto\Pagination;
use Nrg\Form\Element;
use Nrg\Form\Validator\IntegerValidator;
use Nrg\Form\Validator\RangeValidator;

class OffsetElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('offset')
            ->addValidator(new IntegerValidator())
            ->addValidator(
                (new RangeValidator())
                    ->setMinValue(Pagination::MIN_OFFSET)
            )
        ;
    }
}
