<?php


namespace app\modules\import\parsers;


use app\models\Teams;
use app\modules\contract\models\RamkaContract;
use app\modules\contract\models\SpecaContract;
use app\modules\import\components\ConfigInterface;
use app\modules\import\config\SpecaConfig;
use app\modules\import\parsers\ContractBaseParser;


/**
 * SpecaParser
 *
 * @author yiimar
 */
class SpecaParser extends ContractBaseParser
{
    /**
     * Инициализация результирующей строки
     * @return array
     */
    protected function initRecord(): array
    {
        parent::initRecord();
        $this->record['genus'] = SpecaContract::GENUS;
        return $this->record;
    }

    /**
     * Инкапсуляция конфигурации спеки
     * @return ConfigInterface
     */
    public function getConfig(): ConfigInterface
    {
        return $this->config = new SpecaConfig();
    }

    /**
     * Условия поиска для определения уникальности
     * @return array
     */
    protected function searchCondition(): array
    {
        return [
            'number_out' => $this->record['number_out'],
            'genus' => SpecaContract::GENUS,
        ];
    }

    /**
     * Проверка валидности входной строки
     * @return bool
     */
    protected function isValidRow(): bool
    {
        $emptyNum = empty($this->sheetRow['№ Основного Договора']);
        $level = $this->sheetRow['Уровень договора'] == 'Спецификация';
        return $level && !$emptyNum;
    }

    /**
     * Определение AuthUsers::id ответственного за договор, как ВП команды-заявителя
     * @return bool
     */
    protected function makeOwner()
    {
        $teamCode = $this->sheetRow['ID команды (из ФОС)'];
        if (!empty($teamCode)) {
            $teanm = Teams::find()
                ->where(['fos_code' => $teamCode])
                ->one();
            if ($teanm) {
                $this->record['team_id'] = $teanm->id;
                $this->record['resp_id'] = $teanm->owner;
            }
        }
        return true;
    }

    /**
     * Определение рамочного договора
     * @return bool
     * @throws \Exception
     */
    protected function makeParent()
    {
        if ($parent = $this->sheetRow['№ Основного Договора']) {
            $model = RamkaContract::find()
                ->where([
                    'number_out' => $parent,
                    'genus' => RamkaContract::GENUS,
                ])
                ->one();
            if ($model) {
                $this->record['parent_id'] = $model->id;
                return true;
            }
        }
        throw new \Exception('Не найден рамочный договор: ' . $parent);
    }
}