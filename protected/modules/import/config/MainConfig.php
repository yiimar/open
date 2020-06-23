<?php


namespace app\modules\import\config;


use app\modules\import\config\BaseContractConfig;

/**
 * MainConfig
 *
 * @author yiimar
 */
class MainConfig extends BaseContractConfig
{
    public function getClass() : string
    {
        return 'app\modules\contract\models\MainContract';
    }

    public function getScenario(): array
    {
        return [
            'Books',
            'Models',
            'Items',
            'Amounts',
            'Dates',
        ];
    }

    /**
     * У единичного (разового)10 договора parent нет.
     * @param $row
     * @return bool === true
     */
    protected function makeParent()
    {
        return true;
    }
}