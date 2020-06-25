<?php


namespace app\components;


use app\models\Account;

class AccountUpdateBehavior extends \CActiveRecordBehavior
{
    public $sidField;
    public $summaField;
    public $sighnField;

    public function afterSave($event)
    {
        $account = Account::model()->findByAttributes(['client_sid' => $this->owner->{$this->sidField}]);
        if (!$account)
            throw new \CDbException('Ошибка поиска записи счета');
        if ($this->owner->{$this->sighnField}) {
            $account->summa += $this->owner->{$this->summaField};
        } else {
            $account->summa -= $this->owner->{$this->summaField};
        }
        if (!$account->save()) {
            throw new \CDbException('Ошибка записи счета');
        }
    }
}