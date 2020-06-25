<?php

namespace app\models;

use app\models\Client;
use app\components\DActiveRecord;

/**
 * This is the model class for table "account".
 *
 * The followings are the available columns in table 'account':
 * @property integer $id
 * @property integer $client_sid
 * @property string $summa
 *
 * The followings are the available model relations:
 * @property Client $clientS
 */
class Account extends DActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			['client_sid, summa', 'required'],
			['client_sid', 'numerical', 'integerOnly' => true],
			['id, client_sid, summa', 'safe', 'on' => 'search'],
        ];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return [
			'clientS' => [self::HAS_ONE, Client::class, ['sid' => 'client_sid']],
        ];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'client_sid' => 'Sid Клиента',
			'summa' => 'Сумма',
        ];
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return \CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new \CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('client_sid',$this->client_sid);
		$criteria->compare('summa',$this->summa,true);

		return new \CActiveDataProvider($this, [
			'criteria'=>$criteria,
        ]);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Account the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
