<?php

namespace Nrg\Files\Action\Directory;

use Nrg\Http\Value\HttpStatus;
use Nrg\Files\UseCase\Directory\ReadDirectory;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Rx\Abstraction\Observer;
use Nrg\Rx\Service\OnCompleteStub;
use Nrg\Utility\Service\OnErrorResponse;

/**
 * Class ReadDirectoryAction.
 *
 * Reads a directory by a path.
 */
class ReadDirectoryAction implements Observer
{
    use OnCompleteStub;
    use OnErrorResponse;

    /**
     * @var ReadDirectory
     */
    private $readDirectory;

    /**
     * @param ReadDirectory $readDirectory
     */
    public function __construct(ReadDirectory $readDirectory)
    {
        $this->readDirectory = $readDirectory;
    }

    /**
     * Reads a directory by a path.
     *
     * @param HttpExchangeEvent $event
     */
    public function onNext($event)
    {
        $params = $event->getRequest()->getBodyParams();

        $event->getResponse()
            ->setBody($this->readDirectory->execute($params))
            ->setStatus(new HttpStatus(HttpStatus::OK));
    }
}
