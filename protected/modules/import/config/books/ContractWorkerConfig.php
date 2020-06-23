<?php


namespace app\modules\import\config\books;

use app\models\Contractor;
use app\models\TermsOfReference;
use app\modules\book\models\Worker;
use app\modules\book\models\WorkerTor;
use app\modules\contract\models\Contract;
use app\modules\book\models\ContractWorker;
use app\modules\contract\models\SpecaContract;
use app\modules\import\components\BaseConfig;
use app\modules\import\components\ConfigInterface;

/**
 * ContractWorkerConfig
 *
 * @author yiimar
 */
class ContractWorkerConfig extends BaseConfig
{
    public function getClass() : string
    {
        return ContractWorker::class;
    }

    public function getScenario(): array
    {
        return [
            'Models',
            'Dates'
        ];
    }

    public function getModels()
    {
        return [
            [
                'class' => Worker::class,
                'field' => 'worker_id',
                'sheet_column' => 'Ф.И.О. сотрудника (желтым выделены порядчики,к-х нет в ФОС)',
                'search' => [
                    'name' => 'Ф.И.О. сотрудника (желтым выделены порядчики,к-х нет в ФОС)',
                ],
                'factor' => self::MODEL_FACTOR_NOTHING,
                'require' => true,
            ],
            [
                'class' => SpecaContract::class,
                'field' => 'contract_id',
                'sheet_column' => '№ Спецификации',
                'search' => [
                    'number_out' => '№ Спецификации',
                ],
                'factor' => self::MODEL_FACTOR_NOTHING,
                'require' => true,
            ],
        ];
    }

    public function getDates()
    {
        return [
            'Дата начала работы' => 'date_start',//Дата подписания договора
            'Дата завершения работы' => 'date_end',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getItems(): array
    {
        return [];
    }
}