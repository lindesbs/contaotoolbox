<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\Command;

use lindesbs\contaotoolbox\DTO\ProjectsDTO;
use lindesbs\contaotoolbox\DTO\ProjectSettingsDTO;
use lindesbs\contaotoolbox\Service\CTBConfigLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class CreateBasicStructureCommand extends Command
{
    protected static $defaultName = 'contaotools:basicStructure';
    protected static $defaultDescription = 'Erstelle die Default Modul Struktur fuer ein lauffaehiges Contao Modul';

    protected ProjectSettingsDTO $projectSettingsDTO;

    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly CTBConfigLoader $configLoader,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('inputFile', InputArgument::REQUIRED, 'ProjektKonfigDatei');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int|null
    {
        $io = new SymfonyStyle($input, $output);

        $data = $this->configLoader->load($input->getArgument('inputFile'));

        $this->setProjectSettingsDTO($data);

        foreach ($data->getProjects() as $project) {
            $this->createDirectoryIfNotExists($project);
            $this->createDirectoryIfNotExists($project, 'src/Command');
            $this->createDirectoryIfNotExists($project, 'src/ContaoManager');
            $this->createDirectoryIfNotExists($project, 'src/DependencyInjection');
            $this->createDirectoryIfNotExists($project, 'src/Resources/config');
            $this->createDirectoryIfNotExists($project, 'src/Resources/contao/config');
            $this->createDirectoryIfNotExists($project, 'tests');

            $this->createFileFromTwigTemplate(
                $project,
                __DIR__.'/../Templates/Resources/contao/config/config.php.twig',
                [],
                'src/Resources/contao/config/config.php'
            );
        }
        dump($data);

        return Command::SUCCESS;
    }

    protected function createDirectoryIfNotExists(ProjectsDTO $projectsDTO, string $subPath = ''): void
    {
        $path = $this->getSubpath($projectsDTO, $subPath);

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    protected function createFileFromTwigTemplate(ProjectsDTO $projectsDTO, string $templatePath, array $data, string $outputPath): void
    {
        $loader = new FilesystemLoader(\dirname($templatePath));
        $twig = new Environment($loader);

        $content = $twig->render(basename($templatePath), $data);

        $path = sprintf('%s/%s',
            $this->getSubpath($projectsDTO, \dirname($outputPath)),
            basename($outputPath)
        );

        dump($path);

        file_put_contents($path, $content);
    }

    public function getSubpath(ProjectsDTO $projectsDTO, string $subPath): string
    {
        $data = $this->getProjectSettingsDTO();

        return sprintf(
            '/%s/%s/%s/%s',
            trim($this->kernel->getProjectDir(), '\/\\'),
            trim($data->getBasepath(), '\/\\'),
            trim($projectsDTO->getProjectName(), '\/\\'),
            trim($subPath, '\/\\')
        );
    }

    public function getProjectSettingsDTO(): ProjectSettingsDTO
    {
        return $this->projectSettingsDTO;
    }

    public function setProjectSettingsDTO(ProjectSettingsDTO $projectSettingsDTO): void
    {
        $this->projectSettingsDTO = $projectSettingsDTO;
    }
}
