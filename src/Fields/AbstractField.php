<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\Fields;

class AbstractField
{
    private string $inputType;
    private string $sql;
    private bool $exclude;
    private array $eval;

    private int $length;

    private string $tl_class;

    public function __construct()
    {
        $this->setInputType('text');
        $this->setExclude(true);
        $this->setLength(255);
        $this->setTlClass('');

        $this->setSql(sprintf("varchar(%s) NOT NULL default ''", $this->getLength()));

    }

    public function render(): array
    {
        $arrReturn = [];
        $arrReturn['inputtype'] = $this->getInputType();

        $arrReturn['eval'] = [];
        $arrReturn['eval']['maxlength'] = $this->getLength();
        $arrReturn['eval']['tl_class'] = $this->getTlClass();
        $arrReturn['sql'] = $this->getSql();

        return $arrReturn;
    }

    public function getInputType(): string
    {
        return $this->inputType;
    }

    public function setInputType(string $inputType): void
    {
        $this->inputType = $inputType;
    }

    public function getSql(): string
    {
        return $this->sql;
    }

    public function setSql(string $sql): void
    {
        $this->sql = $sql;
    }

    public function isExclude(): bool
    {
        return $this->exclude;
    }

    public function setExclude(bool $exclude): void
    {
        $this->exclude = $exclude;
    }

    public function getEval(): array
    {
        return $this->eval;
    }

    public function setEval(array $eval): void
    {
        $this->eval = $eval;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    public function getTlClass(): string
    {
        return $this->tl_class;
    }

    public function setTlClass(string $tl_class): void
    {
        $this->tl_class = $tl_class;
    }
}
