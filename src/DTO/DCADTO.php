<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\DTO;

class DCADTO extends AbstractDTO
{
    protected DCAConfigDTO $config;
    protected DCAListDTO $list;
    protected DCAPalettesDTO $palettes;

    /**
     * @var array<DCAFieldsDTO>
     */
    protected array $fields;

    /**
     * @param DCAListDTO|null $list
     */
    public function __construct()
    {
        $this->config = new DCAConfigDTO();
        $this->list = new DCAListDTO();
        $this->palettes = new DCAPalettesDTO();
        $this->fields = [];
    }

    public function parse(array $data): bool
    {
        $bWorked = false;
        if (\array_key_exists('config', $data)) {
            $bWorked &= $this->config->parse($data['config']);
        }

        if (\array_key_exists('list', $data)) {
            $bWorked &= $this->list->parse($data['list']);
        }

        if (\array_key_exists('palettes', $data)) {
            $bWorked &= $this->palettes->parse($data['palettes']);
        }

        if (\array_key_exists('fields', $data)) {
            foreach ($data['fields'] as $key => $value) {
                $this->fields[$key] = new DCAFieldsDTO(...$value);
            }
        }

        return (bool) $bWorked;
    }

    public function dump(): array
    {
        $arrData = [
            'config' => $this->config->dump(),
            'list' => $this->list->dump(),
            'palettes' => $this->palettes->dump(),

        ];

        foreach ($this->fields as $keyField => $valueField) {
            $arrData['fields'][$keyField] = $valueField->dump();
        }

        return $arrData;
    }

    public function getConfig(): DCAConfigDTO
    {
        return $this->config;
    }

    public function setConfig(DCAConfigDTO $config): void
    {
        $this->config = $config;
    }

    public function getList(): DCAListDTO
    {
        return $this->list;
    }

    public function setList(DCAListDTO $list): void
    {
        $this->list = $list;
    }

    public function getPalettes(): DCAPalettesDTO
    {
        return $this->palettes;
    }

    public function setPalettes(DCAPalettesDTO $palettes): void
    {
        $this->palettes = $palettes;
    }

    public function getFields(): DCAFieldsDTO
    {
        return $this->fields;
    }

    public function setFields(DCAFieldsDTO $fields): void
    {
        $this->fields = $fields;
    }
}
