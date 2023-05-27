<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\Fields;

class DCAField extends AbstractDCA
{
    public static function Text(string $tlDCA, string $fieldName, ...$arrOptions): void
    {
        self::Generic($tlDCA, $fieldName, 'text',
            [
                'sql' => "varchar(255) NOT NULL default ''",
            ]
        );

    }

    private static function Generic(string $tlDCA, string $fieldName, string $type, array $arrOptions): void
    {
        $arrData = $GLOBALS['TL_DCA'][$tlDCA]['fields'][$fieldName];
        $arrData['inputType'] = $type;

        foreach ($arrOptions as $key => $value) {
            if (\array_key_exists($key, $arrData)) {
                $arrData[$key] = array_merge($arrData[$key], $value);
            } else {
                $arrData[$key] = $value;
            }
        }

        $GLOBALS['TL_DCA'][$tlDCA]['fields'][$fieldName] = array_merge($GLOBALS['TL_DCA'][$tlDCA]['fields'][$fieldName], $arrData);
    }

    private static function ensureExists($tlDCA, $fieldName): void
    {
        if (!\array_key_exists('TL_DCA', $GLOBALS)) {
            $GLOBALS['TL_DCA'] = [];
        }

        if (!\array_key_exists($tlDCA, $GLOBALS['TL_DCA'])) {
            $GLOBALS['TL_DCA'][$tlDCA] = [];
        }

        if (!\array_key_exists('fields', $GLOBALS['TL_DCA'][$tlDCA])) {
            $GLOBALS['TL_DCA'][$tlDCA]['fields'] = [];
        }

        if (!\array_key_exists($fieldName, $GLOBALS['TL_DCA'][$tlDCA]['fields'])) {
            $GLOBALS['TL_DCA'][$tlDCA]['fields'][$fieldName] = [];
        }

        // TL_LANG

        if (!\array_key_exists('TL_LANG', $GLOBALS)) {
            $GLOBALS['TL_LANG'] = [];
        }

        if (!\array_key_exists($tlDCA, $GLOBALS['TL_LANG'])) {
            $GLOBALS['TL_LANG'][$tlDCA] = [];
        }

        if (!\array_key_exists($fieldName, $GLOBALS['TL_LANG'][$tlDCA])) {
            $GLOBALS['TL_LANG'][$tlDCA][$fieldName] = [
                'label' => 'label_'.$fieldName,
                'desc' => 'desc_'.$fieldName,
            ];
        }

        $GLOBALS['TL_DCA'][$tlDCA]['fields'][$fieldName]['label'] = $GLOBALS['TL_LANG'][$tlDCA][$fieldName];

        if (!\array_key_exists('config', $GLOBALS['TL_DCA'][$tlDCA])) {
            $GLOBALS['TL_DCA'][$tlDCA]['config'] = [];
        }

        if (!\array_key_exists('list', $GLOBALS['TL_DCA'][$tlDCA])) {
            $GLOBALS['TL_DCA'][$tlDCA]['list'] = [];
        }

        if (!\array_key_exists('palettes', $GLOBALS['TL_DCA'][$tlDCA])) {
            $GLOBALS['TL_DCA'][$tlDCA]['palettes'] = [];
        }

    }
}
