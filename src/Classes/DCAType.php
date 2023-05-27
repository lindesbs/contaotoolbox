<?php

declare(strict_types=1);

namespace lindesbs\ContaoTools\Classes;

class DCAType
{
    final public const TEXT = 'TEXT';

    final public const INT = 'INT';

    final public const SELECT = 'SELECT';

    final public const CHECKBOX = 'CHECKBOX';

    final public const DATE = 'DATE';

    final public const DATIM = 'DATIM';

    public static function getConfig(string $type): array
    {
        if (self::TEXT === $type) {
            return ['type' => 'text', 'sql' => "varchar(32) NOT NULL default ''"];
        }

        if (self::INT === $type) {
            return ['type' => 'text', 'sql' => "int(10) unsigned NOT NULL default '0'"];
        }

        if (self::SELECT === $type) {
            return ['type' => 'select', 'sql' => "varchar(32) NOT NULL default ''"];
        }

        return [];
        // char(1) COLLATE ascii_bin NOT NULL default ''
    }
}
