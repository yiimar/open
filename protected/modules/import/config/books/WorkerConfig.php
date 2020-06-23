<?php


namespace app\modules\import\config\books;

use app\models\Contractor;
use app\models\Teams;
use app\models\TermsOfReference;
use app\modules\book\models\Worker;
use app\modules\import\components\BaseConfig;

/**
 * WorkerConfig
 *
 * @author yiimar
 */
class WorkerConfig extends BaseConfig
{
    public function getClass() : string
    {
        return Worker::class;
    }

    public function getScenario(): array
    {
        return [
            'Items',
            'Models',
        ];
    }

    public function getItems() : array
    {
        return [
            'name' => 'Ф.И.О. сотрудника (желтым выделены порядчики,к-х нет в ФОС)',
            'email' => 'Адрес электронной почты (sigma)',
        ];
    }

    public function getModels()
    {
        return [
            [
                'class' => Contractor::class,
                'field' => 'contractor_id',
                'sheet_column' => 'Подразделение 2 уровня',//Поставщик
                'search' => [
                    'name' => 'Подразделение 2 уровня',
                ],
                'attributes' => [
                    'name' => 'Подразделение 2 уровня',
                ],
                'factor' => self::MODEL_FACTOR_NEW,
            ],
            [
                'class' => Teams::class,
                'field' => '',
                'sheet_column' => 'Код команды',//Поставщик
                'search' => [
                    'additional_code' => 'Код команды',
                ],
                'attributes' => [
                    'additional_code' => 'Код команды',
                    'name' => 'Команда',// (из ФОС) new
                    'type' => 'Тип команды',
                    'fos_code' => 'Команда ID',
                ],
                'factor' => self::MODEL_FACTOR_NOTHING,
            ],
        ];
    }
}