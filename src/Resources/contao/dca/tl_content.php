<?php

declare(strict_types=1);

use lindesbs\ContaoTools\Classes\Backend\BackendEndpoint;

$GLOBALS['TL_DCA']['tl_content']['list']['global_operations']['dataTransfer'] = [
    'href' => 'key=dataTransfer',
    'icon' => 'back.svg',
    'button_callback' => [BackendEndpoint::class, 'dataTransferExportCallback'],
];
