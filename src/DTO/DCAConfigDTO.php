<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\DTO;

class DCAConfigDTO extends AbstractDTO
{
    protected string $datacontainer = 'Table';

    public function parse(array $data): bool
    {
        $this->setDatacontainer($data['dataContainer']);

        return true;
    }

    public function dump(): array
    {
        return [
            'dataContainer' => $this->getDatacontainer(),
        ];
    }

    public function getDatacontainer(): string
    {
        return $this->datacontainer;
    }

    public function setDatacontainer(string $datacontainer): void
    {
        $this->datacontainer = $datacontainer;
    }
}
