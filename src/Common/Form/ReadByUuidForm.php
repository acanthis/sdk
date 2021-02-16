<?php

namespace Eds\Common\Form;

use Eds\Common\Form\Element\UuidElement;
use Nrg\Form\Element;
use Nrg\Form\Form;

class ReadByUuidForm extends Form
{
    public function __construct()
    {
        $this
            ->addElement(
                (new UuidElement())
                    ->isRequired()
            )
            ->addElement(
                (new Element())
                    ->setName('type.name')
            )
        ;
    }
}