<?php

declare(strict_types=1);

namespace lindesbs\ContaoTools\Classes\Backend;

use Contao\BackendTemplate;
use Contao\Controller;
use Contao\Database;
use Contao\DataContainer;
use Contao\File;
use Contao\Input;
use Contao\System;
use lindesbs\ContaoTools\Builder\HRefBuilder;
use lindesbs\ContaoTools\DTO\DataTransferElementDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class BackendEndpoint extends Controller
{
    private Request $request;

    private string $tableName = '';
    private int $tableId = 0;

    public function dataTransferExportCallback(string $href, string $label, string $title, string $class, string $attributes): string
    {
        return HRefBuilder::HRef($href, $label, $title, $class, $attributes);
    }

    public function exportContent(DataContainer $dataContainer): string
    {
        $backendTemplate = new BackendTemplate('be_contaotools');
        $this->request = System::getContainer()->get('request_stack')->getCurrentRequest();

        $this->setTableName((string) $this->request->get('table'));
        $this->setTableId((int) $this->request->get('id'));

        if ('' === $this->getTableName()) {
            throw new \RuntimeException('Shpuld not happen. Empty tableName');
        }

        if ('getExport' === Input::post('EXPORT_SUBMIT')) {
            $this->handleExport();
        }

        $database = Database::getInstance();

        $strSelect = sprintf('SELECT * FROM %s WHERE pid=%s', $this->getTableName(), $this->getTableId());
        $resultItems = $database->execute($strSelect);

        $arrTemplateData = [
            'formId' => 'form_'.$this->request->get('id'),
            'requestToken' => System::getContainer()->get('contao.csrf.token_manager')->getDefaultTokenValue(),
            'labelSubmit' => 'Herunterladen',
            'labelExport' => 'Daten exportieren',
            'labelImport' => 'Daten importieren',
            'tableName' => $this->getTableName(),
            'tableId' => $this->getTableId(),
            'itemCount' => $resultItems->count(),
        ];

        $backendTemplate->setData($arrTemplateData);

        return $backendTemplate->parse();
    }

    /**
     * @throws \Exception
     */
    private function handleExport(): void
    {
        $database = Database::getInstance();

        $strSelect = sprintf('SELECT * FROM %s WHERE pid=%s ORDER BY sorting', $this->getTableName(), $this->getTableId());
        $resultItems = $database->execute($strSelect);

        if ($resultItems) {
            $creationDate = date('YmdHi', time());

            $exportFile = sprintf('system/tmp/%s_export_id%s_%s.json',
                $this->getTableName(),
                $this->getTableId(),
                $creationDate
            );

            $theData = new DataTransferElementDTO(
                $this->getTableName(),
                $this->getTableId(),
                $resultItems->fetchAllAssoc()
            );

            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];

            $serializer = new Serializer($normalizers, $encoders);
            $jsonContent = $serializer->serialize($theData, 'json');

            $objfile = new File($exportFile);
            $objfile->write($jsonContent);
            $objfile->close();
            $objfile->sendToBrowser();
        }
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function setTableName(string $tableName): self
    {
        $this->tableName = $tableName;

        return $this;
    }

    public function getTableId(): int
    {
        return $this->tableId;
    }

    public function setTableId(int $tableId): self
    {
        $this->tableId = $tableId;

        return $this;
    }
}
