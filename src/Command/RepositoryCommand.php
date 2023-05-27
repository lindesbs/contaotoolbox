<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\Command;

use lindesbs\contaotoolbox\Service\Config;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'contaotoolbox:repository')]
class RepositoryCommand extends Command
{
    public function __construct(private readonly Config $config)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        return Command::SUCCESS;
    }
}
