<?php


namespace app\modules\import\parsers;


use app\modules\contract\models\RamkaContract;
use app\modules\import\components\ConfigInterface;
use app\modules\import\config\RamkaConfig;
use app\modules\import\parsers\ContractBaseParser;

/**
 * RamkaParser
 *
 * @author yiimar
 */
class RamkaParser extends ContractBaseParser
{
    /**
     * Инициализация результирующей строки
     * @return array
     */
    protected function initRecord(): array
    {
        parent::initRecord();
        $this->record['genus'] = RamkaContract::GENUS;
        return $this->record;
    }

    /**
     * Инкапсуляция конфигурации рамки
     * @return ConfigInterface
     */
    public function getConfig(): ConfigInterface
    {
        return $this->config = new RamkaConfig();
    }

    /**
     * Условия поиска для определения уникальности
     * @return array
     */
    protected function searchCondition(): array
    {
        return [
            'number_out' => $this->record['number_out'],
            'genus' => RamkaContract::GENUS,
        ];
    }

    /**
     * Проверка валидности входной строки
     * @return bool
     */
    protected function isValidRow(): bool
    {
        $emptyNum = empty($this->sheetRow['№ Основного Договора']);
        $level = $this->sheetRow['Уровень договора'] == 'Рамочный договор';
        return $level && !$emptyNum;
    }

    /**
     * У рамочного договора parent нет.
     * @param $row
     * @return bool === true
     */
    protected function makeParent()
    {
        return true;
    }
}