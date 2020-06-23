<?php


namespace app\modules\import\parsers\books;


use app\modules\book\models\Worker;
use app\modules\import\components\BaseParser;
use app\modules\import\components\ConfigInterface;
use app\modules\import\config\books\WorkerConfig;

/**
 * WorkerParser
 *
 * @author yiimar
 */
class WorkerParser extends BaseParser
{
    protected function initRecord(): array
    {
        parent::initRecord();
        $this->record['status'] = Worker::STATUS_AVAILABLE;
        return $this->record;
    }

    public function getConfig(): ConfigInterface
    {
        return $this->config = new WorkerConfig();
    }

    protected function searchCondition(): array
    {
        return [
            'name' => $this->record['name']
//            'like', 'name', $this->record['Ф.И.О. сотрудника (желтым выделены порядчики,к-х нет в ФОС)'] . '%', false
        ];
    }

    protected function isValidRow(): bool
    {
        $name = !empty($this->sheetRow['Ф.И.О. сотрудника (желтым выделены порядчики,к-х нет в ФОС)']);
        $contractor =!empty($this->sheetRow['Подразделение 2 уровня']);
        return $name && $contractor;
    }
}