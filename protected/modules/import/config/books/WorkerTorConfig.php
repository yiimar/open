<?php


namespace app\modules\import\config\books;

use app\models\Contractor;
use app\models\LvlCompetence;
use app\models\TermsOfReference;
use app\modules\book\models\Worker;
use app\modules\book\models\WorkerTor;
use app\modules\import\components\BaseConfig;
use app\modules\import\components\ConfigInterface;

/**
 * WorkerTorConfig
 *
 * @author yiimar
 */
class WorkerTorConfig extends BaseConfig implements ConfigInterface
{
    public function getClass() : string
    {
        return WorkerTor::class;
    }

    public function getScenario(): array
    {
        return [
            'Models',
        ];
    }

    public function getModels()
    {
        return [
            [
                'class' => LvlCompetence::class,
                'field' => 'lvl_competence_id',
                'sheet_column' => 'Уровень',
                'search' => [
                    'name' => 'Уровень',
                ],
                'factor' => self::MODEL_FACTOR_NOTHING,
            ],
            [
                'class' => TermsOfReference::class,
                'field' => 'terms_of_reference_id',
                'sheet_column' => 'Область компетенции',
                'search' => [
                    'terms_of_reference' => 'Область компетенции',
                    'name' => 'Компетенция',
                ],
                'attributes' => [
                    'terms_of_reference' => 'Область компетенции',
                    'name' => 'Компетенция',
                ],
                'factor' => self::MODEL_FACTOR_NEW,
            ],
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