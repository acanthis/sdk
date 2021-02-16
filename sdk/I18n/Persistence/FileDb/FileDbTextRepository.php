<?php

namespace Nrg\I18n\Persistence\FileDb;

use Nrg\I18n\Persistence\Abstraction\TextRepository;
use Nrg\I18n\Persistence\Exception\I18nStorageNotFound;

class FileDbTextRepository implements TextRepository
{
    private const FILE_EXTENSION = '.php';

    private const TEXTS_FOLDER = 'texts';

    private string $i18nPath;

    private array $texts = [];

    public function __construct(string $i18nPath)
    {
        $this->i18nPath = realpath($i18nPath);
        if (false === $this->i18nPath) {
            throw new I18nStorageNotFound('I18n path not found.');
        }
    }

    public function findByKey(string $key, string $locale): ?string
    {
        if (!isset($this->texts[$locale])) {
            $filePath = realpath($this->i18nPath.DIRECTORY_SEPARATOR.self::TEXTS_FOLDER.DIRECTORY_SEPARATOR.$locale.self::FILE_EXTENSION);
            if (false === $filePath) {
                return null;
            }
            $this->texts[$locale] = require $filePath;
        }

        return $this->texts[$locale][$key] ?? null;
    }
}
