<?php

namespace Eds\Contractor\Form\Group;

use Eds\Common\Form\Element\ClientIdElement;
use Eds\Common\Form\Element\CreatorIdElement;
use Eds\Contractor\Form\Element\Group\GroupNameElement;
use Nrg\Form\Form;

class GroupCreateForm extends Form
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
                (new GroupNameElement())
                    ->isRequired()
            )
        ;
    }
}
