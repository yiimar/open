<?php


namespace app\modules\import\parsers\books;


use app\modules\book\models\Worker;
use app\modules\import\components\BaseParser;
use app\modules\import\components\ConfigInterface;
use app\modules\import\config\books\TorConfig;
use app\modules\import\config\books\WorkerConfig;

/**
 * TorParser
 *
 * @author yiimar
 */
class TorParser extends BaseParser
{
//    protected function initRecord(): array
//    {
//        parent::initRecord();
//        $this->record['status'] = Worker::STATUS_AVAILABLE;
//        return $this->record;
//    }

    public function getConfig(): ConfigInterface
    {
        return $this->config = new TorConfig();
    }

    protected function searchCondition(): array
    {
        return [
            'name' => $this->sheetRow['Компетенция'],
            'terms_of_reference' => $this->sheetRow['Область компетенции'],
        ];
    }

    protected function isValidRow(): bool
    {
        return !empty($this->sheetRow['Область компетенции']);
    }
}