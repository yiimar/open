<?php

/**
 * This is the model class for table "client".
 *
 * The followings are the available columns in table 'client':
 * @property integer $id
 * @property integer $sid
 * @property string $fio
 *
 * The followings are the available model relations:
 * @property Account[] $accounts
 * @property ClientPayment[] $clientPayments
 */
class Client extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'client';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['sid, fio', 'required'],
			['sid', 'numerical', 'integerOnly'=>true],
			['fio', 'length', 'max'=>255],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			['id, sid, fio', 'safe', 'on'=>'search'],
        ];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return [
			'account'       => [self::HAS_ONE,  'Account',       ['sid' => 'client_sid']],
			'clientPayments' => [self::HAS_MANY, 'ClientPayment', ['sid' => 'client_sid']],
        ];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'sid' => 'Sid',
			'fio' => 'ФИО',
            'accoumt.id' => ' № счета',
            'account.summa' => 'Остаток на счету',
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
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('sid',$this->sid);
		$criteria->compare('fio',$this->fio,true);

		return new CActiveDataProvider($this, [
			'criteria'=>$criteria,
        ]);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Client the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
