<?php


namespace app\modules\import\config;

use app\modules\import\config\BaseContractConfig;
use app\modules\contract\models\RamkaContract;

/**
 * RamkaConfig
 *
 * @author yiimar
 */
class RamkaConfig extends BaseContractConfig
{
    /**
     * @return string
     */
    public function getClass() : string
    {
        return RamkaContract::class;
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
        ];
    }

    /**
     * Массив полей дат
     * @return array
     */
    public function getDates()
    {
        return [
            'Дата подписания договора' => 'date_contract',
            'Дата окончания договора' => 'date_end_contract',
        ];
    }

    /**
     * Массив строчных полей прямого соответвствия
     * @return array
     */
    public function getItems() : array
    {
        return [
             'headline' => 'Предмет договора',
             'number_out' => '№ Основного Договора',
        ];
    }

    /**
     * Массив полей сумм
     * @return array
     */
    public function getAmounts()
    {
        return [
            'Лимит договора руб. с НДС' => 'amount_rub',//Сумма рамочного дог. с НДС (руб.)
            'НДС, %' => 'vat_percent',
        ];
    }
}