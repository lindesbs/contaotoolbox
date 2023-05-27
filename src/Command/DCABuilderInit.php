<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\Command;

use lindesbs\contaotoolbox\Service\CTBConfigLoader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Yaml\Yaml;

#[AsCommand(name: 'contaotoolbox:dcabuilder:init')]
class DCABuilderInit extends Command
{
    protected static $defaultName = 'contaotoolbox:dcabuilder:init';
    protected static $defaultDescription = 'Erstelle die Default Modul Struktur';

    private Serializer $serializer;
    private ValidatorInterface $validator;

    public function __construct(
        private readonly CTBConfigLoader $configLoader,
    ) {

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(Yaml::dump($this->configLoader->init()));

        return Command::SUCCESS;
    }
}
