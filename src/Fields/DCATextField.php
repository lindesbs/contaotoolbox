<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\Fields;

class DCATextField extends AbstractField
{
    public function __construct()
    {
        parent::__construct();

        $this->setInputType('text');
        $this->setExclude(true);
        $this->setLength(255);
    }
}
