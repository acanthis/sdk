<?php

namespace Eds\CustomFields\Form;

use Eds\Common\Form\Element\ClientIdElement;
use Eds\Common\Form\Element\CreatorIdElement;
use Eds\CustomFields\Form\Element\DescriptionElement;
use Eds\CustomFields\Form\Element\IsRequiredOnCreateElement;
use Eds\CustomFields\Form\Element\IsRequiredOnUpdateElement;
use Eds\CustomFields\Form\Element\IsShowOnCreateElement;
use Eds\CustomFields\Form\Element\IsShowOnUpdateElement;
use Eds\CustomFields\Form\Element\IsUniqueElement;
use Eds\CustomFields\Form\Element\IsUseInFilterElement;
use Eds\CustomFields\Form\Element\NameElement;
use Eds\CustomFields\Form\Element\TypeElement;
use Nrg\Form\Form;

abstract class CustomFiledBaseForm extends Form
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
                (new NameElement())
                    ->isRequired()
            )
            ->addElement(
                (new TypeElement())
                    ->isRequired()
            )
            ->addElement(
                (new IsRequiredOnCreateElement())
                    ->isRequired()
            )
            ->addElement(
                (new IsRequiredOnUpdateElement())
                    ->isRequired()
            )
            ->addElement(
                (new IsShowOnCreateElement())
                    ->isRequired()
            )
            ->addElement(
                (new IsShowOnUpdateElement())
                    ->isRequired()
            )
            ->addElement(
                (new IsUniqueElement())
                    ->isRequired()
            )
            ->addElement(
                (new IsUseInFilterElement())
                    ->isRequired()
            )
            ->addElement(
                (new DescriptionElement())
            )
        ;
    }

    abstract public function canBeUsed(array $array): bool;
}
