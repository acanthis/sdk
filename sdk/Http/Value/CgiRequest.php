<?php

namespace Nrg\Http\Value;

/**
 * HTTP request implementation.
 */
class CgiRequest extends HttpRequest
{
    public function __construct()
    {
        $this
            ->setProtocolVersion(substr($_SERVER['SERVER_PROTOCOL'], strpos($_SERVER['SERVER_PROTOCOL'], '/') + 1))
            ->setUrl(new CgiUrl())
            ->setMethod($_SERVER['REQUEST_METHOD'])
            ->setCookies($_COOKIE)
            ->setQueryParams($_GET)
            ->setBody(file_get_contents('php://input'))
            ->setBodyParams($_POST)
            ->setUploadedFiles($this->convertToUploadedFiles($_FILES))
        ;

        foreach (getallheaders() as $name => $value) {
            $this->setHeader($name, $value);
        }
    }

    private function normalization(array $files): array
    {
        $result = [];

        foreach ($files as $key => $file) {
            foreach ($file as $name => $param) {
                if (is_array($param)) {
                    foreach ($param as $index => $value) {
                        $result[$key][$index][$name] = $value;
                    }
                } else {
                    $result[$key][$name] = $param;
                }
            }
        }

        return $result;
    }

    /**
     * Converts each of array items to UploadedFile.
     */
    private function convertToUploadedFiles(array $files): array
    {
        $normalizedFiles = $this->normalization($files);
        $uploadedFiles = [];

        foreach ($normalizedFiles as $key => $file) {
            if (isset($file['name'])) {
                $uploadedFiles[$key] = new UploadedFile(
                    $file['name'],
                    $file['type'],
                    $file['tmp_name'],
                    $file['error'],
                    $file['size']
                );
                continue;
            }

            foreach ($file as $index => $values) {
                $uploadedFiles[$key][$index] = new UploadedFile(
                    $values['name'],
                    $values['type'],
                    $values['tmp_name'],
                    $values['error'],
                    $values['size']
                );
            }
        }

        return $uploadedFiles;
    }
}
