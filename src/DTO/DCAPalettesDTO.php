<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\DTO;

class DCAPalettesDTO extends AbstractDTO
{
    public function parse(array $data): bool
    {
        return true;
    }

    public function dump(): array
    {
        return [];
    }
}
