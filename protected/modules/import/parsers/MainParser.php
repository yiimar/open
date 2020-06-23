<?php


namespace app\modules\import\parsers;


use app\modules\contract\models\MainContract;
use app\modules\import\components\ConfigInterface;
use app\modules\import\config\MainConfig;
use app\modules\import\parsers\ContractBaseParser;

/**
 * MainParser
 *
 * @author yiimar
 */
class MainParser extends ContractBaseParser
{
    protected function initRecord(): array
    {
        parent::initRecord();
        $this->record['genus'] = MainContract::GENUS;
        return $this->record;
    }

    public function getConfig(): ConfigInterface
    {
        return $this->config =  new MainConfig();
    }

    protected function isValidRow(): bool
    {
        return boolval(
            strlen($this->sheetRow['Номер карточки рамочного договора']) < 10
            && strlen($this->sheetRow['Номер карточки договора']) > 10
        );
    }

    /**
     * У единичного договора parent нет.
     * @param $row
     * @return bool === true
     */
    public function makeParent()
    {
        return true;
    }
}