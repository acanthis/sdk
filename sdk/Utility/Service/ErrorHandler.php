<?php

namespace Nrg\Utility\Service;

use ErrorException;

class ErrorHandler
{
    /**
     * Which of errors need translation.
     */
    private int $errorTypes;

    /**
     * Ignores the error_reporting directive at runtime if it's true.
     */
    private bool $ignoreErrorReporting;

    /**
     * Ignores the control operator (@) if it's true.
     */
    private bool $ignoreControlOperator;

    /**
     * Internal variable to know if translation is enabled.
     */
    private bool $enabled = false;

    /**
     * Used for replacing error message.
     */
    private ?string $errorMessage;

    public function __construct(
        $errorTypes = E_ALL | E_STRICT,
        $ignoreErrorReporting = true,
        $ignoreControlOperator = false
    ) {
        $this->errorTypes = $errorTypes;
        $this->ignoreErrorReporting = $ignoreErrorReporting;
        $this->ignoreControlOperator = $ignoreControlOperator;
    }

    /**
     * Enables a translation from error to ErrorException.
     */
    public function enable()
    {
        set_error_handler(
            function ($code, $message, $file, $line) {
                return $this->errorHandler($code, $message, $file, $line);
            },
            $this->errorTypes
        );

        register_shutdown_function(
            function () {
                if ($this->enabled) {
                    $this->shutdownHandler();
                }
            }
        );

        $this->enabled = true;
    }

    /**
     * Disables a translation from error to ErrorException.
     */
    public function disable()
    {
        set_error_handler(null);
        $this->enabled = false;
    }

    /**
     * Sets permanently error message instead of real exception's message.
     */
    public function replaceErrorMessage(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * Translates regular errors to ErrorException.
     *
     * @throws ErrorException
     */
    private function errorHandler(string $code, string $message, string $file, string $line): bool
    {
        if (!$this->ignoreErrorReporting) {
            if (!$this->ignoreControlOperator && 0 === error_reporting()) {
                return false;
            }
            if (!(error_reporting() & $code)) {
                return false;
            }
        }

        throw new ErrorException($this->errorMessage ?? $message, $code, 1, $file, $line);
    }

    /**
     * Translates errors occurred on shutdown.
     *
     * @throws ErrorException // todo: Handle it
     */
    private function shutdownHandler()
    {
        $error = error_get_last();
        if (null !== $error) {
            $this->errorHandler($error['type'], $error['message'], $error['file'], $error['line']);
        }
    }
}
