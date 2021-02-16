<?php

namespace Eds\CustomFields\Form;

use Eds\CustomFields\Form\Element\DescriptionElement;
use Eds\CustomFields\Form\Element\IsMarkOnDeleteElement;
use Eds\CustomFields\Form\Element\IsRequiredOnCreateElement;
use Eds\CustomFields\Form\Element\IsRequiredOnUpdateElement;
use Eds\CustomFields\Form\Element\IsShowOnCreateElement;
use Eds\CustomFields\Form\Element\IsShowOnUpdateElement;
use Eds\CustomFields\Form\Element\IsUniqueElement;
use Eds\CustomFields\Form\Element\IsUseInFilterElement;
use Eds\CustomFields\Form\Element\NameElement;
use Nrg\Form\Element\UuidRequiredElement;
use Nrg\Form\Form;

class DocumentCustomFieldsUpdateForm extends Form
{
    public function __construct()
    {
        $this
            ->addElement(new UuidRequiredElement())
            ->addElement((new NameElement())
                ->isRequired()
            )
            ->addElement(new IsRequiredOnCreateElement())
            ->addElement(new IsRequiredOnUpdateElement())
            ->addElement(new IsShowOnCreateElement())
            ->addElement(new IsShowOnUpdateElement())
            ->addElement(new IsUniqueElement())
            ->addElement(new IsUseInFilterElement())
            ->addElement(new IsMarkOnDeleteElement())
            ->addElement(new DescriptionElement())
        ;
    }
}
