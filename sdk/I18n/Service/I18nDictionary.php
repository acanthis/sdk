<?php

namespace Nrg\I18n\Service;

use Nrg\I18n\Abstraction\Dictionary;
use Nrg\I18n\Persistence\Abstraction\TextRepository;
use Nrg\I18n\Persistence\FileDb\FileDbTextRepository;

class I18nDictionary implements Dictionary
{
    private TextRepository $repository;

    public function __construct(TextRepository $repository = null)
    {
        $this->repository = $repository;
    }

    public function translate(string $text, string $locale): string
    {
        return $this->getRepository()->findByKey($text, $locale) ?? $text;
    }

    protected function getI18nPath(): string
    {
        return __DIR__.'/../../I18n';
    }

    private function getRepository(): TextRepository
    {
        if (null === $this->repository) {
            $this->repository = new FileDbTextRepository($this->getI18nPath());
        }

        return $this->repository;
    }
}
