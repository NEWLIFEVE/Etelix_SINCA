<?php

/**
 * This is the model class for table "log".
 *
 * The followings are the available columns in table 'log':
 * @property integer $id
 * @property string $date
 * @property string $hour
 * @property integer $id_log_action
 * @property integer $id_users
 * @property string $description_date
 * @property integer $id_esp
 *
 * The followings are the available model relations:
 * @property LogAction $idLogAction
 * @property Users $idUsers
 */
class LogSori extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, hour', 'required'),
			array('id_log_action, id_users, id_esp', 'numerical', 'integerOnly'=>true),
			array('description_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, hour, id_log_action, id_users, description_date, id_esp', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idLogAction' => array(self::BELONGS_TO, 'LogAction', 'id_log_action'),
			'idUsers' => array(self::BELONGS_TO, 'Users', 'id_users'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date' => 'Date',
			'hour' => 'Hour',
			'id_log_action' => 'Id Log Action',
			'id_users' => 'Id Users',
			'description_date' => 'Description Date',
			'id_esp' => 'Id Esp',
		);
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('hour',$this->hour,true);
		$criteria->compare('id_log_action',$this->id_log_action);
		$criteria->compare('id_users',$this->id_users);
		$criteria->compare('description_date',$this->description_date,true);
		$criteria->compare('id_esp',$this->id_esp);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->soriDB;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogSori the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getLogSori($fecha)
	{
            $nuevafecha = strtotime('+1 day',strtotime($fecha));
            $nuevafecha = date('Y-m-j',$nuevafecha);
            
            $model = self::model()->findAllBySql("SELECT id, date, id_log_action
                                                  FROM log
                                                  WHERE date = '$nuevafecha'
                                                  AND id_log_action > 2 AND id_log_action < 5;");
            return $model;
	}
}
