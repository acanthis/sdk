<?php

namespace Eds\Contractor\Form\Group;

use Eds\Contractor\Form\Element\Group\GroupNameElement;
use Nrg\Form\Element\UuidRequiredElement;
use Nrg\Form\Form;

class GroupUpdateForm extends Form
{
    public function __construct()
    {
        $this
            ->addElement(new UuidRequiredElement())
            ->addElement(
                (new GroupNameElement())
                    ->isRequired()
            )
        ;
    }
}
