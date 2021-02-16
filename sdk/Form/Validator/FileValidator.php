<?php

namespace Nrg\Form\Validator;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\Http\Value\UploadedFile;
use Nrg\I18n\Value\Message;

class FileValidator implements ValidatorInterface
{
    use ErrorsTrait;

    private const ERROR_FILE_TYPE = 'form_validation_file.invalidType';
    private const ERROR_FILE_MAX_SIZE = 'form_validation_file.cannotBeGreater';
    private const ERROR_FILE_UPLOAD = 'form_validation_file.errorUpload';

    private array $allowTypes = [];
    private int $maxFileSize;

    public function __construct(array $allowTypes, int $maxFileSize)
    {
        $this->allowTypes = $allowTypes;
        $this->maxFileSize = $maxFileSize;
    }

    public function isValid(ElementInterface $element): bool
    {
        /** @var UploadedFile $file */
        $file = $element->getValue();

        if ($this->isLargeFileUpload($file->getError())) {
            $this->setErrors(new Message(self::ERROR_FILE_MAX_SIZE, ['maxFileSize' => ini_get('upload_max_filesize'), 'file' => $file->getName()]));

            return false;
        }

        if ($this->isUploadError($file->getError())) {
            $this->setErrors(new Message(self::ERROR_FILE_UPLOAD, ['errorCode' => $file->getError(), 'file' => $file->getName()]));

            return false;
        }

        if (!$this->validateFileType($file->getType())){
            $this->setErrors(new Message(self::ERROR_FILE_TYPE, ['allowTypes' => $this->allowTypes, 'file' => $file->getName()]));

            return false;
        }

        if (!$this->validateMaxFileSize($file->getSize())){
            $this->setErrors(new Message(self::ERROR_FILE_MAX_SIZE, ['maxFileSize' => $this->maxFileSize, 'file' => $file->getName()]));

            return false;
        }

        return true;
    }

    private function validateFileType(string $fileType): bool
    {
        return in_array($fileType, $this->allowTypes, true);
    }

    private function validateMaxFileSize(int $length): bool
    {
        return $length < $this->maxFileSize;
    }

    private function isLargeFileUpload(int $errorCode): bool
    {
        if (UPLOAD_ERR_INI_SIZE === $errorCode || UPLOAD_ERR_FORM_SIZE === $errorCode) {
            return true;
        }

        return false;
    }

    private function isUploadError(int $errorCode): bool
    {
        if (UPLOAD_ERR_OK !== $errorCode) {
            return true;
        }

        return false;
    }
}
