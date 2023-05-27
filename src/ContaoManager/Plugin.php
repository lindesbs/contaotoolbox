<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use lindesbs\contaotoolbox\ContaoToolboxBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ContaoToolboxBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
