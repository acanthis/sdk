<?php

namespace Eds\Contractor\Form\Status;

use Eds\Contractor\Form\Element\Status\StatusColorElement;
use Eds\Contractor\Form\Element\Status\StatusNameElement;
use Nrg\Form\Element\UuidRequiredElement;
use Nrg\Form\Form;

class StatusUpdateForm extends Form
{
    public function __construct()
    {
        $this
            ->addElement(new UuidRequiredElement())
            ->addElement(
                (new StatusNameElement())
                    ->isRequired()
            )
            ->addElement(
                (new StatusColorElement())
                    ->isRequired()
            )
        ;
    }
}
