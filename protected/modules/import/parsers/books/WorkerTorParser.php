<?php


namespace app\modules\import\parsers\books;


use app\models\LvlCompetence;
use app\models\TermsOfReference;
use app\modules\book\models\Worker;
use app\modules\import\components\BaseParser;
use app\modules\import\components\ConfigInterface;
use app\modules\import\config\books\WorkerTorConfig;

/**
 * WorkerTorParser
 *
 * @author yiimar
 */
class WorkerTorParser extends BaseParser
{
    protected function getWorkerId()
    {
        return Worker::find()
            ->where(['name' => $this->sheetRow['Ф.И.О. сотрудника (желтым выделены порядчики,к-х нет в ФОС)']])
            ->one()->id ?? '';
    }

    protected function getTorId()
    {
        return TermsOfReference::find()
            ->where([
                'name' => $this->sheetRow['Компетенция'],
                'terms_of_reference' => $this->sheetRow['Область компетенции'],
            ])->one()->id ?? '';
    }
    public function getConfig(): ConfigInterface
    {
        return $this->config = new WorkerTorConfig();
    }

    protected function searchCondition(): array
    {
        return [
            'worker_id' => $this->getWorkerId(),
            'terms_of_reference_id' => $this->getTorId(),
        ];
    }

    protected function makeWorkerTor()
    {
        if ($workerId = $this->getWorkerId()) {
            if ($torId = $this->getTorId()) {
                $this->record['worker_id'] = $workerId;
                $this->record['terms_of_reference_id'] = $torId;
                $this->record['lvl_competence_id'] = LvlCompetence::find()
                    ->where(['name' => $this->sheetRow['Уровень']])
                    ->one()->id ?? '';
                return true;
            } else {
                return false;
            }
        } else {
            throw new \Exception('Нет такого работника:' . $this->sheetRow['Ф.И.О. сотрудника (желтым выделены порядчики,к-х нет в ФОС)']);
        }
    }
    protected function isValidRow(): bool
    {
        $worker = !empty($this->sheetRow['Ф.И.О. сотрудника (желтым выделены порядчики,к-х нет в ФОС)']);
        $tor = !empty($this->sheetRow['Область компетенции']);
        return $worker && $tor;
    }
}