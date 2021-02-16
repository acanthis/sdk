<?php

namespace Eds\Contractor\Form\Status;

use Eds\Contractor\Form\Element\Status\StatusIdsElement;
use Nrg\Form\Form;

class StatusDeleteForm extends Form
{
    public function __construct()
    {
        $this
            ->addElement(
                (new StatusIdsElement())
                    ->isRequired()
            )
        ;
    }
}
