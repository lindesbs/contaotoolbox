<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\Command;

use Contao\Controller;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\System;
use lindesbs\contaotoolbox\DTO\DCADTO;
use lindesbs\contaotoolbox\Service\CTBConfigLoader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(name: 'contaotoolbox:dcabuilder:generate')]
class DCABuilderGenerate extends Command
{
    protected static $defaultName = 'contaotoolbox:dcabuilder:generate';
    protected static $defaultDescription = 'Erstelle die Default Modul Struktur fuer ein lauffaehiges Contao Modul';

    private Serializer $serializer;
    private ValidatorInterface $validator;

    public function __construct(
        private readonly CTBConfigLoader $configLoader,
        private readonly ContaoFramework $framework
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('inputFile', InputArgument::REQUIRED, 'ProjektKonfigDatei');
        $this->addArgument('module', InputArgument::REQUIRED, 'Modul');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int|null
    {
        $io = new SymfonyStyle($input, $output);

        $this->framework->initialize();

        $data = $this->configLoader->load($input->getArgument('inputFile'));

        foreach ($data->getProjects() as $project) {

            $io->writeln('Loading');

            foreach ($project->getDca() as $dc=>$dcValue) {
                Controller::loadDataContainer($dc);
;
                $arrDCA = $dcValue;
                $dca = new DCADTO();
                $dca->parse($GLOBALS['TL_DCA'][$dc]);

                $dca->parse($arrDCA);

                $io->warning('MemoryData');
                $this->varexport($dca->dump());
            }

        }

        return Command::SUCCESS;
    }

    function varexport($expression, $return=FALSE) {
        $export = var_export($expression, TRUE);
        $patterns = [
            "/array \(/" => '[',
            "/^([ ]*)\)(,?)$/m" => '$1]$2',
            "/=>[ ]?\n[ ]+\[/" => '=> [',
            "/([ ]*)(\'[^\']+\') => ([\[\'])/" => '$1$2 => $3',
        ];
        $export = preg_replace(array_keys($patterns), array_values($patterns), $export);
        if ((bool)$return) return $export; else echo $export;
    }
}