<?php

namespace Eds\Contractor\Service;

use Eds\Contractor\Abstraction\ConfigInterface;
use Eds\Contractor\Dto\Config\PackageDocConfig;

class Config implements ConfigInterface
{
    private PackageDocConfig $packageDoc;

    public function __construct(array $packageDoc)
    {
        $this->packageDoc = new PackageDocConfig($packageDoc['allowTypes'], $packageDoc['maxFileSize'], $packageDoc['filePathPattern']);
    }

    public function getPackageDoc(): PackageDocConfig
    {
        return $this->packageDoc;
    }
}