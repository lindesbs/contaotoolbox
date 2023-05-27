<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\DTO;

class DCALabel
{
    protected string $class;
    protected string $func;

    public function __construct(string $class, string $func)
    {
        $this->class = $class;
        $this->func = $func;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function setClass(string $class): void
    {
        $this->class = $class;
    }

    public function getFunc(): string
    {
        return $this->func;
    }

    public function setFunc(string $func): void
    {
        $this->func = $func;
    }
}
