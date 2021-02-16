<?php

namespace Nrg\Auth\Form\Validator;

use Nrg\Auth\Abstraction\SecureInterface;
use Nrg\Auth\UseCase\GetUserById;
use Nrg\Data\Exception\EntityNotFoundException;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;
use Throwable;

class TokenValidator implements ValidatorInterface
{
    use ErrorsTrait;

    private const ERROR = 'auth_validation_invalidToken';

    private GetUserById $getUserById;
    private SecureInterface $secure;
    private ?int $tokenType = null;

    public function __construct(GetUserById $getUserById, SecureInterface $secure)
    {
        $this->getUserById = $getUserById;
        $this->secure = $secure;
    }

    public function isValid(ElementInterface $element): bool
    {
        try {
            $token = $this->secure->parseToken($element->getValue());
        } catch (Throwable $e) {
            $this->setErrors(new Message(self::ERROR));

            return false;
        }

        if (!$this->secure->isValidToken($token, $this->tokenType)) {
            $this->setErrors(new Message(self::ERROR));

            return false;
        }

        try {
            $user = $this->getUserById->execute(
                $token->getClaim(SecureInterface::CLAIM_USER_ID)
            );
        } catch (EntityNotFoundException $e) {
            $this->setErrors(new Message(self::ERROR));

            return false;
        }

        if (!$this->secure->verifyToken($token, $user)) {
            $this->setErrors(new Message(self::ERROR));

            return false;
        }

        return true;
    }

    public function setTokenType(int $tokenType): TokenValidator
    {
        $this->tokenType = $tokenType;

        return $this;
    }
}
