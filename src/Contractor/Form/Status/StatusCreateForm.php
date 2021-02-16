<?php

namespace Eds\Contractor\Form\Status;

use Eds\Common\Form\Element\ClientIdElement;
use Eds\Common\Form\Element\CreatorIdElement;
use Eds\Contractor\Form\Element\Status\StatusColorElement;
use Eds\Contractor\Form\Element\Status\StatusNameElement;
use Nrg\Form\Form;

class StatusCreateForm extends Form
{
    public function __construct()
    {
        $this
            ->addElement(
                (new ClientIdElement())
                    ->isRequired()
            )
            ->addElement(
                (new CreatorIdElement())
                    ->isRequired()
            )
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
