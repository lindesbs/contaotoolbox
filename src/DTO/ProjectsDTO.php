<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\DTO;

class ProjectsDTO
{
    protected string $projectName;
    protected bool $active;
    protected string $description;
    protected array $dca;

    public function __construct(string $project, bool $active = true, string $description = '', array $dca = [])
    {
        if (!$this->checkNameIsProjectAware($project)) {
            throw new \Exception(sprintf('Falsches Format fuer Projekt [%s]', $project));
        }

        $this->projectName = $project;
        $this->active = $active;
        $this->description = $description;
        $this->dca = $dca;

        if (!$this->description) {
            $this->description = $this->projectName;
        }
    }

    protected function checkNameIsProjectAware(string $name): bool
    {
        $project = explode('/', $name);

        return 2 === \count($project);
    }

    public function getProjectName(): string
    {
        return $this->projectName;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDca(): array
    {
        return $this->dca;
    }

    public function setDca(array $dca): void
    {
        $this->dca = $dca;
    }
}
