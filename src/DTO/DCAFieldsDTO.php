<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\DTO;

class DCAFieldsDTO extends AbstractDTO
{
    /**
     * @var string|DCALabel|array
     */
    protected mixed $label;
    protected string $inputType;
    protected bool $exclude;
    protected string $default;
    protected bool $toggle;

    protected string $sql;
    protected bool $search;
    protected bool $sorting;
    protected bool $filter;
    protected int $flag;
    protected int $length;

    protected array $options;
    protected string $foreignKey;
    protected string $reference;
    protected string $explanation;
    protected array $eval;
    protected array $relation;

    protected DCACallback|null $optionsCallback;
    protected DCACallback|null $inputFieldCallback;

    /**
     * @var array<DCACallback>
     */
    protected array $wizard;
    /**
     * @var array<DCACallback>
     */
    protected array $loadCallback;
    /**
     * @var array<DCACallback>
     */
    protected array $saveCallback;

    /**
     * @var array<DCACallback>
     */
    protected array $xLabel;

    /**
     * @param string|array $label
     * @param string $inputType
     * @param bool $exclude
     * @param string $default
     * @param bool $toggle
     * @param string $sql
     * @param bool $search
     * @param bool $sorting
     * @param bool $filter
     * @param int $flag
     * @param int $length
     * @param array $options
     * @param string $foreignKey
     * @param string $reference
     * @param string $explanation
     * @param array $eval
     * @param array $relation
     * @param DCACallback|null $optionsCallback
     * @param DCACallback|null $inputFieldCallback
     * @param array<DCACallback> $wizard
     * @param array<DCACallback> $loadCallback
     * @param array<DCACallback> $saveCallback
     * @param array<DCACallback> $xLabel
     */
    public function __construct(
        string|array $label = '',
        string $inputType = '',
        bool $exclude = false,
        string $default = '',
        bool $toggle = false,
        string $sql = '',
        bool $search = false,
        bool $sorting = false,
        bool $filter = false,
        int $flag = -1,
        int $length = -1,
        array $options = [],
        string $foreignKey = '', string $reference = '', string $explanation = '', array $eval = [],
        array $relation = [], DCACallback $optionsCallback = null, DCACallback $inputFieldCallback = null,
        array $wizard = [], array $loadCallback = [], array $saveCallback = [], array $xLabel = [])
    {
        $this->label = $label;
        $this->inputType = $inputType;
        $this->exclude = $exclude;
        $this->default = $default;
        $this->toggle = $toggle;
        $this->sql = $sql;
        $this->search = $search;
        $this->sorting = $sorting;
        $this->filter = $filter;
        $this->flag = $flag;
        $this->length = $length;
        $this->options = $options;
        $this->foreignKey = $foreignKey;
        $this->reference = $reference;
        $this->explanation = $explanation;
        $this->eval = $eval;
        $this->relation = $relation;
        $this->optionsCallback = $optionsCallback;
        $this->inputFieldCallback = $inputFieldCallback;
        $this->wizard = $wizard;
        $this->loadCallback = $loadCallback;
        $this->saveCallback = $saveCallback;
        $this->xLabel = $xLabel;

        $this->manageSQL();
    }

    public function parse(array $data): bool
    {
        if (\array_key_exists('label', $data)) {
            $this->setLabel($data['label']);
        }

        if (\array_key_exists('inputType', $data)) {
            $this->setInputType($data['inputType']);
        }

        $this->exclude = $data['exclude'];
        $this->default = $data['default'];
        $this->toggle = $data['toggle'];
        $this->sql = $data['sql'];
        $this->search = $data['search'];
        $this->sorting = $data['sorting'];
        $this->filter = $data['filter'];
        $this->flag = $data['flag'];
        $this->length = $data['length'];
        $this->options = $data['options'];
        $this->foreignKey = $data['foreignKey'];
        $this->reference = $data['reference'];
        $this->explanation = $data['explanation'];
        $this->eval = $data['eval'];
        $this->relation = $data['relation'];
        $this->optionsCallback = $data['optionsCallback'];
        $this->inputFieldCallback = $data['inputFieldCallback'];
        $this->wizard = $data['wizard'];
        $this->loadCallback = $data['loadCallback'];
        $this->saveCallback = $data['saveCallback'];
        $this->xLabel = $data['xLabel'];

        return true;
    }

    public function dump(): array
    {
        $this->manageSQL();
        $arrData = [];

        if ('' !== $this->getLabel()) {
            $arrData['label'] = $this->getLabel();
        }

        if ('' !== $this->getInputType()) {
            $arrData['inputType'] = $this->getInputType();
        }

        if ('' !== $this->getSql()) {
            $arrData['sql'] = $this->getSql();
        }

        if (('' !== $this->getEval()) &&
            ([] !== $this->getEval())){
            $arrData['eval'] = $this->getEval();
        }

        return $arrData;
    }

    protected function manageSQL(): void
    {

        switch ($this->getInputType()) {
            case 'text': $this->setSql("VARCHAR(255) NOT NULL DEFAULT ''");

                break;
            case 'number': $this->setInputType('text');
                $this->putEval('rgxp', 'number');
                break;

            case 'bool': $this->setSql("CHAR(1) NOT NULL DEFAULT ''");
                break;
            case 'longtext': $this->setSql('text NULL');
                break;
            case 'int': $this->setSql('INT UNSIGNED NULL');
                break;

            default: $this->setSql("VARCHAR(255) NOT NULL DEFAULT ''");
                $this->setLength(255);
                $this->putEval('rgxp', 'text');
                $this->putEval('length', 255);
                break;
        }

        if (
            ('text' === $this->checkEval('rgxp')) &&
            $this->checkEval('length') &&
            $this->getLength()
        ) {
            $this->setSql(sprintf("VARCHAR(%s) NOT NULL DEFAULT ''", $this->getLength()));
        }
    }

    protected function checkEval(string $key)
    {
        if (!$this->getEval()) {
            return null;
        }

        if (!\array_key_exists($key, $this->getEval())) {
            return null;
        }

        $eval = $this->getEval();

        return $eval[$key];

    }

    public function putEval(string $key, mixed $value): void
    {
        if (!$this->getEval()) {
            $this->setEval([]);
        }

        $this->eval[$key] = $value;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getInputType(): string
    {
        return $this->inputType;
    }

    public function setInputType(string $inputType): void
    {
        $this->inputType = $inputType;

        $this->manageSQL();
    }

    public function isExclude(): bool
    {
        return $this->exclude;
    }

    public function setExclude(bool $exclude): void
    {
        $this->exclude = $exclude;
    }

    public function getDefault(): string
    {
        return $this->default;
    }

    public function setDefault(string $default): void
    {
        $this->default = $default;
    }

    public function isToggle(): bool
    {
        return $this->toggle;
    }

    public function setToggle(bool $toggle): void
    {
        $this->toggle = $toggle;
    }

    public function getSql(): string
    {
        return $this->sql;
    }

    public function setSql(string $sql): void
    {
        $this->sql = $sql;
    }

    public function isSearch(): bool
    {
        return $this->search;
    }

    public function setSearch(bool $search): void
    {
        $this->search = $search;
    }

    public function isSorting(): bool
    {
        return $this->sorting;
    }

    public function setSorting(bool $sorting): void
    {
        $this->sorting = $sorting;
    }

    public function isFilter(): bool
    {
        return $this->filter;
    }

    public function setFilter(bool $filter): void
    {
        $this->filter = $filter;
    }

    public function getFlag(): int
    {
        return $this->flag;
    }

    public function setFlag(int $flag): void
    {
        $this->flag = $flag;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length): void
    {
        $this->length = $length;

        $this->manageSQL();
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function getForeignKey(): string
    {
        return $this->foreignKey;
    }

    public function setForeignKey(string $foreignKey): void
    {
        $this->foreignKey = $foreignKey;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function setReference(string $reference): void
    {
        $this->reference = $reference;
    }

    public function getExplanation(): string
    {
        return $this->explanation;
    }

    public function setExplanation(string $explanation): void
    {
        $this->explanation = $explanation;
    }

    public function getEval(): array
    {
        return $this->eval;
    }

    public function setEval(array $eval): void
    {
        $this->eval = $eval;
    }

    public function getRelation(): array
    {
        return $this->relation;
    }

    public function setRelation(array $relation): void
    {
        $this->relation = $relation;
    }

    public function getOptionsCallback(): DCACallback
    {
        return $this->optionsCallback;
    }

    public function setOptionsCallback(DCACallback $optionsCallback): void
    {
        $this->optionsCallback = $optionsCallback;
    }

    public function getInputFieldCallback(): DCACallback
    {
        return $this->inputFieldCallback;
    }

    public function setInputFieldCallback(DCACallback $inputFieldCallback): void
    {
        $this->inputFieldCallback = $inputFieldCallback;
    }

    public function getWizard(): array
    {
        return $this->wizard;
    }

    public function setWizard(array $wizard): void
    {
        $this->wizard = $wizard;
    }

    public function getLoadCallback(): array
    {
        return $this->loadCallback;
    }

    public function setLoadCallback(array $loadCallback): void
    {
        $this->loadCallback = $loadCallback;
    }

    public function getSaveCallback(): array
    {
        return $this->saveCallback;
    }

    public function setSaveCallback(array $saveCallback): void
    {
        $this->saveCallback = $saveCallback;
    }

    public function getXLabel(): array
    {
        return $this->xLabel;
    }

    public function setXLabel(array $xLabel): void
    {
        $this->xLabel = $xLabel;
    }
}
