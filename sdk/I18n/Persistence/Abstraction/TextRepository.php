<?php

namespace Nrg\I18n\Persistence\Abstraction;

interface TextRepository
{
    public function findByKey(string $key, string $locale): ?string;
}
