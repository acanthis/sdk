<?php

namespace Nrg\Files\Action\Hyperlink;

use Nrg\Files\Form\Hyperlink\CreateHyperlinkForm;
use Nrg\Files\UseCase\Hyperlink\CreateHyperlink;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Value\HttpStatus;
use Nrg\Rx\Abstraction\Observer;
use Nrg\Rx\Service\ObserverStub;

/**
 * Class CreateHyperlinkAction.
 *
 * Creates a hyperlink with a path and a contents, the contents is url.
 */
class CreateHyperlinkAction implements Observer
{
    use ObserverStub;

    /**
     * @var CreateHyperlinkForm
     */
    private $form;

    /**
     * @var CreateHyperlink
     */
    private $createHyperlink;

    /**
     * @param CreateHyperlinkForm $form
     * @param CreateHyperlink $createHyperlink
     */
    public function __construct(CreateHyperlinkForm $form, CreateHyperlink $createHyperlink)
    {
        $this->form = $form;
        $this->createHyperlink = $createHyperlink;
    }

    /**
     * Creates a hyperlink with a path and a contents, contents is optional.
     *
     * @param HttpExchangeEvent $event
     */
    public function onNext($event)
    {
        $this->form->populate($event->getRequest()->getBodyParams());

        if ($this->form->hasErrors()) {
            $event->getResponse()
                ->setStatus(new HttpStatus(HttpStatus::UNPROCESSABLE_ENTITY))
                ->setBody($this->form->serialize());
        } else {
            $event->getResponse()
                ->setBody($this->createHyperlink->execute($this->form->serialize()))
                ->setStatus(new HttpStatus(HttpStatus::CREATED));
        }
    }
}
