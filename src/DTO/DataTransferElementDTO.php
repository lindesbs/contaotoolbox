<?php

declare(strict_types=1);

namespace lindesbs\ContaoTools\DTO;

use Contao\Controller;

class DataTransferElementDTO
{
    private string $generator;
    private float $version;
    private string $creationDate;
    private string $table;
    private int $id;

    private string $hash = '';

    private array $dataContent;

    public function __construct(string $table, int $id, array $jsonContent)
    {
        $this->setCreationDate(new \DateTimeImmutable());
        $this->version = 0.1;
        $this->generator = 'DataTransfer';
        $this->table = $table;
        $this->id = $id;
        $this->setDataContent($jsonContent);
    }

    public function getVersion(): float
    {
        return $this->version;
    }

    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeImmutable $creationDate): void
    {
        $this->creationDate = $creationDate->format(DATE_W3C);
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDataContent(): array
    {
        return $this->dataContent;
    }

    public function setDataContent(array $dataContent): void
    {
        Controller::loadDataContainer($this->getTable());
        $arrConvertKeys = [];

        $definition = $GLOBALS['TL_DCA'][$this->getTable()]['fields'];

        foreach ($definition as $key => $value) {
            if (\array_key_exists('sql', $value) && \is_string($value['sql'])) {
                if (str_contains($value['sql'], 'binary')) {
                    $arrConvertKeys[$key] = $key;
                }
            }
        }

        if (\count($arrConvertKeys) > 0) {
            foreach ($arrConvertKeys as $theKey) {

                foreach ($dataContent as $number => $item) {
                    foreach ($item as $key => $value) {

                        if (($theKey === $key) && (null !== $dataContent[$number][$key])) {
                            $dataContent[$number][$key] = base64_encode($dataContent[$number][$key]);

                        }
                    }
                }
            }
        }

        $this->hash = md5(json_encode($dataContent));

        $this->dataContent = $dataContent;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getGenerator(): string
    {
        return $this->generator;
    }
}
