<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\DTO;

abstract class AbstractDTO
{
    abstract public function parse(array $data): bool;

    abstract public function dump(): array;
}
