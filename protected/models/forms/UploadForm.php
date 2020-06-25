<?php

namespace app\models\forms;

use app\components\FormModel;
use app\helpers\UploadHelper;
use app\models\Client;
use app\models\Account;
use app\models\ClientPayment;
use app\modules\import\components\PssService;

class UploadForm extends FormModel
{
    const CLIENT_TABLE = 'first';
    const ACCOUNT_TABLE = 'second';
    const REQUIRED_LIST_NAME = [
        self::CLIENT_TABLE,
        self::ACCOUNT_TABLE,
    ];

    public $file;
    public $enableExt;

    public function init()
    {
        $this->enableExt = \Yii::app()->params['enaibleExt'];
    }

    public function rules()
    {
        return [
            ['file', 'file', 'types' => $this->enableExt, 'maxSize'=>1024 * 1024 * 25,], // 25 MB
        ];
    }

    public function proccess()
    {
        $this->file = \CUploadedFile::getInstance($this, 'file');
        $this->validateFile();
        if ($this->claccSave() && $this->pmSave()) {
            return true;
        }
        return false;
    }

    protected function validateFile()
    {
        $nameList = PssService::getSheetNameList($this->file->tempName);
        if ( !empty($diff = array_diff(self::REQUIRED_LIST_NAME, $nameList)) ) {
            throw new \CException('Исходный файл не содержит таблицу: ' . $diff);
        }
        return true;
    }

    public function claccSave()
    {
        $table = PssService::getTable($this->file->tempName, self::CLIENT_TABLE);
        foreach ($table as $row) {
            $criteria = [
                'sid' => (integer)$row[0],
                'fio' => ltrim($row[1]),
            ];
            $client = Client::findOrInsert($criteria);
            if ($client instanceof Client) {
                $criteria = [
                    'client_sid' => $client->sid,
                    'summa' => $row[2],
                ];
                Account::findOrInsert($criteria);
            }
        }
        return true;
    }

    public function pmSave()
    {
        $table = PssService::getTable($this->file->tempName, self::ACCOUNT_TABLE);
        foreach ($table as $row) {
            $sid = (int)$row[0];
            if (!(Client::model()->findByAttributes(['sid' => $sid]))) {
                throw new \CDbException('Не найден клиент с идентификатором = ' . $sid);
            }
            $res = UploadHelper::sumWithSighn($row[1]);
            $criteria = [
                'client_sid' => $sid,
                'debkred' => $res['debkred'],
                'summa' => $res['summa'],
            ];
            ClientPayment::findOrInsert($criteria);
        }
        return true;
    }
}