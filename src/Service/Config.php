<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\Service;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;

class Config
{
    public function __construct(
        private readonly KernelInterface $kernel,
    ) {
        $this->init();
    }

    private function init(): void
    {
        $strConfigFile = $this->kernel->getProjectDir().'.ctb.yaml';

        if (!file_exists($strConfigFile)) {
            file_put_contents($strConfigFile, 'ctb:');
        }

        $theConfig = Yaml::parseFile($strConfigFile);

        dump($theConfig);
    }
}
