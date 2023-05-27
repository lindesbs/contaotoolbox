<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\DTO;

class DCAListDTO extends AbstractDTO
{
    protected string $mode = 'mode01';

    public function parse(array $data): bool
    {
        return true;
    }

    public function dump(): array
    {
        return [
            'mode' => $this->mode,
        ];
    }
}
