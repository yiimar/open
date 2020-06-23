<?php


namespace app\modules\import\config;


use app\models\Teams;
use app\modules\import\config\BaseContractConfig;
use app\modules\contract\models\SpecaContract;

/**
 * SpecaConfig
 *
 * @author yiimar
 */
class SpecaConfig extends BaseContractConfig
{
    /**
     * @return string
     */
    public function getClass() : string
    {
        return 'app\modules\contract\models\SpecaContract';
    }

    /**
     * Список и порядок выполнения сценариев обработки
     * @return array
     */
    public function getScenario(): array
    {
        return [
            'Models',
            'Items',
            'Amounts',
            'Dates',
//            'Users',
            'Owners',
            'Parent',
        ];
    }

    /**
     * Массив полей сумм
     * @return array
     */
    public function getAmounts()
    {
        return [
            'Сумма по спецификации, руб. с НДС' => 'amount_rub',
            'НДС, %' => 'vat_percent',
        ];
    }

    /**
     * Титул колонки инициатора
     * @return string
     */
    public function getOwners()
    {
        return [
            [
                'class' => Teams::class,
                'table_column' => 'resp_id',
                'sheet_column' => 'ID команды (из ФОС) new',
            ],
        ];
    }

    /**
     * Массив полей дат
     * @return array
     */
    public function getDates()
    {
        return [
            'Дата начала работ по спецификации' => 'date_start_contract',
            'Дата завершения работ по спецификации' => 'date_end_contract',
        ];
    }

    /**
     * Массив строчных полей прямого соответвствия
     * @return array
     */
    public function getItems() : array
    {
        return [
            'subject' => 'Предмет договора',
            'headline' => 'Предмет договора',
            'number_out' => '№ Спецификации (в ЭДО)',
        ];
    }
}