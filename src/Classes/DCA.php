<?php

declare(strict_types=1);

namespace lindesbs\ContaoTools\Classes;

class DCA
{
    private static array $palette = [];

    /**
     * @return array{palettes: string, fields: array<mixed>}
     */
    public static function DCA(string $strDCANeme, bool|string $merge, array $fields): array
    {
        $arrLocalDCA = [];
        $arrLocalDCA['palettes'] = self::getPalette();

        $arrLocalDCA['fields'] = $fields;

        if ($merge) {
            // dd($GLOBALS['TL_DCA']['tl_content']);

            foreach ($fields as $field) {
                $GLOBALS['TL_DCA']['tl_content']['fields'][$field['alias']] = $field['content'];
            }

            $strMergeInKey = 'default';

            if (\is_string($merge)) {
                $strMergeInKey = $merge;
            }

            $GLOBALS['TL_DCA']['tl_content']['palettes'][$strMergeInKey] = ';'.self::getPalette();
        }

        return $arrLocalDCA;
    }

    public static function Group(string $strName, array $arrFields): array
    {
        $arrPalettes = [];
        $strPaletteKey = 'group'.ucfirst($strName);
        $arrPalettes[$strPaletteKey] = [];

        foreach ($arrFields as $arrField) {
            if (!\array_key_exists('alias', $arrField)) {
                throw new \Exception('missing DCA Field Structure');
            }

            $arrPalettes[$strPaletteKey][] = $arrField['alias'];
        }

        self::setPalette($arrPalettes);

        return $arrFields;
    }

    /**
     * @return array{alias: string, content: array<mixed>}
     */
    public static function Field(string $strAlias, string $type, array $arrOptions = [], array $arrEvals = []): array
    {
        $arrContent = [
            'label' => [
                'label'.$strAlias,
                'description'.$strAlias,
            ],

            'eval' => $arrEvals,
        ];

        if (\is_string($arrOptions)) {
            $arrContent['options_callback'] = $arrOptions;
        }

        $arrContent['options'] = $arrOptions;

        $arrContent = array_merge($arrContent, DCAType::getConfig($type));

        return [
            'alias' => $strAlias,
            'content' => $arrContent,
        ];
    }

    public static function getPaletteAsArray(): array
    {
        return self::$palette;
    }

    public static function getPalette(): string
    {
        $arrPalette = [];

        foreach (self::getPaletteAsArray() as $key => $value) {
            $arrPalette[] = sprintf('{%s},%s', $key, implode(',', $value));
        }

        return implode(';', $arrPalette);
    }

    public static function setPalette(array $palette): void
    {
        self::$palette = array_merge(self::getPaletteAsArray(), $palette);
    }

    public static function flattenArray($array, $prefix = '')
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (\is_array($value)) {
                $result = array_merge($result, self::flattenArray($value, $prefix.$key.'.'));
            } else {
                $result[$prefix.$key] = $value;
            }
        }

        return $result;
    }
}
