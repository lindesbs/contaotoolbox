<?php

declare(strict_types=1);

namespace lindesbs\ContaoTools\Controller;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class BackendCountArticlesController
{
    public function __construct(
        private readonly Connection $connection,
    ) {
        $GLOBALS['TL_CSS'][] = 'files/layout/css/backend.css';

    }

    /**
     * @param array  $row
     * @param string $href
     * @param string $label
     * @param string $title
     * @param string $icon
     * @param string $attributes
     *
     * @return string
     *
     * @throws Exception
     */
    public function contentCountCallback($row, $href, $label, $title, $icon, $attributes)
    {
        $strSelect = sprintf("SELECT count(id) as cnt FROM tl_content WHERE pid=%s AND ptable='tl_article'", $row['id']);
        $resultItems = $this->connection->executeQuery($strSelect);
        $resultRow = $resultItems->fetchAllKeyValue();

        $strStyle = 'display:inline-block; text-overflow:ellipsis;border:1px solid black;border-radius:4px;margin:2px;padding:2px;';

        return sprintf("<p style='%s'>%s</p>", $strStyle, $resultRow['cnt']);

    }
}
