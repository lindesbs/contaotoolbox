<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\Service;

use Contao\CoreBundle\Framework\ContaoFramework;
use lindesbs\contaotoolbox\DTO\ProjectSettingsDTO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;

class CTBConfigLoader
{
    public function __construct(
        private readonly ContaoFramework $framework,
        private readonly KernelInterface $kernel,
    ) {
    }

    public function load(string $strConfigFile)
    {

        $this->framework->initialize();

        $loader = Yaml::parse(file_get_contents($strConfigFile));
        if (!\is_array($loader)) {
            $io->warning('Not a yaml file');

            return Command::FAILURE;
        }

        return new ProjectSettingsDTO(...$loader);
    }

    /**
     * Die Rueckgabe muss ein Array sein. Die Generierung desselbigengleichen erfolgt anders.
     */
    public function init(): array
    {
        // Todo : Hier schoeneres generieren des Dumps. Evt. die Klasse in ein array dumpen?
        return [
            'basepath' => 'change me',
            'projects' => [
                'changeme' => [
                    'project' => 'change/me',
                    'active' => true,
                    'description' => 'the description',
                ],
            ],
        ];
    }
}
