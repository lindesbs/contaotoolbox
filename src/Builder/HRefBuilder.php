<?php

declare(strict_types=1);

namespace lindesbs\ContaoTools\Builder;

use Contao\Backend;
use Contao\StringUtil;

class HRefBuilder
{
    public static function HRef(string $href, string $label, string $title, string $class, string $attributes): string
    {

        return sprintf("<a href='%s' title='%s' class='%s' %s>%s</a>",
            Backend::addToUrl($href),
            StringUtil::specialchars($title),
            $class,
            trim($attributes),
            $label
        );
    }

    public static function HRefKey(string $href, string $label, string $title, string $class, string $attributes): string
    {

        return sprintf("<a href='%s' title='%s' class='%s' %s>%s</a>",
            Backend::addToUrl($href),
            StringUtil::specialchars($title),
            $class,
            trim($attributes),
            $label
        );
    }

    public static function modal(string $href, string $label, string $title, string $class, string $attributes): string
    {

        return sprintf('<a href="%s" title="%s" class="%s" onclick="Backend.openModalIframe({\'title\':\'%s\',\'url\':this.href});return false" %s>%s</a>',
            Backend::addToUrl($href),
            StringUtil::specialchars($title),
            $class,
            StringUtil::specialchars($title),
            trim($attributes),
            $label
        );
    }
}
