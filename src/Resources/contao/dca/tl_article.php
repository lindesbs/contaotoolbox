<?php

declare(strict_types=1);

use lindesbs\ContaoTools\Controller\BackendCountArticlesController;

$GLOBALS['TL_DCA']['tl_article']['list']['operations']['contentCount'] = [
    'href' => '#',
    'icon' => 'back.svg',
    'button_callback' => [BackendCountArticlesController::class, 'contentCountCallback'],
];
