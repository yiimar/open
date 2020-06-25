<?php

namespace app\models;

use app\components\AccountUpdateBehavior;
use app\components\DActiveRecord;
use app\models\Client;

/**
 * This is the model class for table "client_payment".
 *
 * TODO: В будущем для сущности добавить поле даты "created" и zii.behaviors.CTimestampBehavior
 *
 * The followings are the available columns in table 'client_payment':
 * @property integer $id
 * @property integer $client_sid
 * @property integer $debkred
 * @property string $summa
 *
 * The followings are the available model relations:
 * @property Client $clientS
 */
class ClientPayment extends DActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'client_payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			['client_sid, summa', 'required'],
			['client_sid, client_sid', 'numerical', 'integerOnly' => true],
            ['debkred', 'boolean'],

			['id, client_sid, debkred, summa', 'safe', 'on' => 'search'],
		];
	}

	public function behaviors()
    {
        return [
            'accountUpdateBehavior' => [
                'class' => AccountUpdateBehavior::class,
                'sidField' => 'client_sid',
                'summaField' => 'summa',
                'sighnField' => 'debkred',
            ],
        ];
    }

    /**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return [
			'clientS' => [self::BELONGS_TO, Client::class, 'client_sid'],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id'         => 'ID',
			'client_sid' => 'sid клиента',
			'debkred'    => 'Дебет/Кредит',
			'summa'      => 'Сумма',
		];
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * @return \CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new \CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('client_sid',$this->client_sid);
		$criteria->compare('debkred',$this->debkred);
		$criteria->compare('summa',$this->summa,true);

		return new \CActiveDataProvider($this, [
			'criteria' => $criteria,
		]);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return \ClientPayment the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
