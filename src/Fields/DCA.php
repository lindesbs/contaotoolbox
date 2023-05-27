<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\Fields;

use Contao\DC_Table;

class DCA
{
    protected static $connection;

    protected string $tlDCA;
    protected string $palettes = '';

    public static function init(string $tlDCA)
    {
        if (!static::$connection) {
            static::$connection = new self();
        }

        static::$connection->tlDCA = $tlDCA;

        if (!\array_key_exists('TL_DCA', $GLOBALS)) {
            $GLOBALS['TL_DCA'] = [];
        }
        if (!\array_key_exists($tlDCA, $GLOBALS['TL_DCA'])) {
            $GLOBALS['TL_DCA'][$tlDCA] = [];
        }

        return self::$connection;
    }

    /**
     * var Config $configs.
     */
    public function config(array $configs): self
    {
        $this->setValue('config/dataContainer', DC_Table::class);
        $this->setValue('config/enableVersioning', true);
        $this->setValue('config/sql/keys/id', 'primary');

        return static::$connection;
    }

    /**
     * var DCAField $dcaFields.
     */
    public function addField(string $name, string $fieldType = null, array $dcaFields = []): self
    {

        if (!$fieldType) {
            $arrField = new DCATextField();
        } else {
            $arrField = new $fieldType();
        }

        $this->setValue('fields/'.$name, $arrField->render());
        $this->addPalette($name);

        return static::$connection;
    }

    public function addSection(string $label): self
    {
        $this->palettes .= trim(sprintf(';{title_%s}', $label), ';');

        return static::$connection;
    }

    private function setValue(string $path, mixed $value): void
    {
        $parts = explode('/', $path);
        $result = $GLOBALS['TL_DCA'][$this->tlDCA];
        $current = &$result;

        foreach ($parts as $part) {
            $current = &$current[$part];
        }

        $current = $value;

        $GLOBALS['TL_DCA'][$this->tlDCA] = array_merge($GLOBALS['TL_DCA'][$this->tlDCA], $result);
    }

    private function addPalette($name): void
    {
        $this->palettes .= sprintf(',%s', $name);
        $this->setValue('palettes/default', $this->palettes);
    }
}
