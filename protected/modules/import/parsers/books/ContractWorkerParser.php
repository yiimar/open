<?php


namespace app\modules\import\parsers\books;


use app\models\LvlCompetence;
use app\modules\book\models\Worker;
use app\modules\contract\models\Contract;
use app\modules\book\models\ContractWorker;
use app\modules\contract\models\SpecaContract;
use app\modules\import\components\BaseParser;
use app\modules\import\components\ConfigInterface;
use app\modules\import\config\books\ContractWorkerConfig;

/**
 * ContractWorkerParser
 *
 * @author yiimar
 */
class ContractWorkerParser extends BaseParser
{
    protected function getWorkerId()
    {
        return Worker::find()
            ->where(['name' => $this->sheetRow['Ф.И.О. сотрудника (желтым выделены порядчики,к-х нет в ФОС)']])
            ->one()->id ?? '';
    }

    protected function getContractId()
    {
        return SpecaContract::find()
            ->where(['number_out' => $this->sheetRow['№ Спецификации'],
            ])->one()->id ?? '';
    }

    public function getConfig(): ConfigInterface
    {
        return $this->config = new ContractWorkerConfig();
    }

    protected function searchCondition(): array
    {
        return [
            'worker_id' => $this->getWorkerId(),
            'contract_id' => $this->getContractId(),
        ];
    }

    protected function makeContractWorker()
    {
        if (!empty($this->getContractId()) && $this->getWorkerI()) {
            $condition = $this->searchCondition();
            if ($cw = ContractWorker::find()->where($condition)->one() ) {
                $cw->delete();
            }
            $this->record['worker_id'] = $this->getWorkerId();
            $this->record['contract_id'] = $this->getContractId();
            return true;
        }
        return false;
    }
    protected function isValidRow(): bool
    {
        $contractId = $this->getContractId();
        $workerId = $this->getWorkerId();
        return !empty($workerId) && !empty($this->sheetRow['№ Спецификации']);
    }
}