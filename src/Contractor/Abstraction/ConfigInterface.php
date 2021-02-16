<?php

namespace Eds\Contractor\Abstraction;

use Eds\Contractor\Dto\Config\PackageDocConfig;

interface ConfigInterface
{
    public function getPackageDoc(): PackageDocConfig;
}