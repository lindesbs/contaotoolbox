<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\DTO;

class ProjectSettingsDTO
{
    protected string $basepath;

    /**
     * @var array ProjectsDTO[]
     */
    protected array $projects;

    public function __construct(string $basepath = '', array $projects = [])
    {
        $this->basepath = $basepath;

        foreach ($projects as $projectKey => $projectValue) {
            $data = new ProjectsDTO(...$projectValue);

            if ($data->isActive()) {
                $this->projects[$projectKey] = $data;
            }
        }
    }

    public function getSourcePath(string $module): string
    {
        if (!\array_key_exists($module, $this->projects)) {
            throw new \Exception('Unknown module');
        }

        /** @var ProjectsDTO $project */
        $project = $this->projects[$module];

        return sprintf('%s/%s/src',
            $this->getBasepath(),
            $project->getProjectName()
        );
    }

    public function getBasepath(): string
    {
        return $this->basepath;
    }

    public function setBasepath(string $basepath): void
    {
        $this->basepath = $basepath;
    }

    /**
     * @return array<ProjectsDTO>
     */
    public function getProjects(): array
    {
        return $this->projects;
    }

    public function setProjects(array $projects): void
    {
        $this->projects = $projects;
    }
}
