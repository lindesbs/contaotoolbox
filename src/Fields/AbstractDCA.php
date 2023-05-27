<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\Fields;

class AbstractDCA
{
    public function setValue(string $path, mixed $value): void
    {
        $parts = explode('/', $path);
        $result = [];
        $current = &$result;

        foreach ($parts as $part) {
            $current = &$current[$part];
        }

        $current = $value;

        $GLOBALS['TL_DCA'][$this->tlDCA] = array_merge_recursive($GLOBALS['TL_DCA'][$this->tlDCA], $result);
    }
}
