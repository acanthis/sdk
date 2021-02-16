<?php

namespace Nrg\Auth\Middleware;

use Nrg\Auth\Abstraction\SecureInterface;
use Nrg\Auth\Form\Element\TokenElement;
use Nrg\Auth\UseCase\GetUserById;
use Nrg\Auth\Value\TokenType;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\UnauthorizedException;

class Authorization
{
    private const HEADER_NAME = 'Authorization';

    private TokenElement $element;
    private SecureInterface $secure;
    private GetUserById $getUserById;

    public function __construct(
        TokenElement $element,
        SecureInterface $secure,
        GetUserById $getUserById
    ) {
        $this->element = $element;
        $this->secure = $secure;
        $this->getUserById = $getUserById;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $request = $event->getRequest();

        $authorization = $request->getQueryParam(self::HEADER_NAME) ??
            $request->getHeaderLine(self::HEADER_NAME);

        if (empty($authorization)) {
            throw new UnauthorizedException();
        }

        $this->element
            ->setValue($authorization)
            ->setTokenType(TokenType::ACCESS);

        if (!$this->element->isValid()) {
            throw new UnauthorizedException();
        }

        $token = $this->secure->parseToken($authorization);
        $user = $this->getUserById->execute($token->getClaim(SecureInterface::CLAIM_USER_ID));
    }
}
