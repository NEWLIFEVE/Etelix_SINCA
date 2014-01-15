<?php

/**
 * This is the model class for table "log".
 *
 * The followings are the available columns in table 'log':
 * @property integer $Id
 * @property string $Fecha
 * @property string $Hora
 * @property string $FechaEsp
 * @property integer $ACCIONLOG_Id
 * @property integer $USERS_Id
 *
 * The followings are the available model relations:
 * @property Accionlog $aCCIONLOG
 * @property Users $uSERS
 */
class Log extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Log the static model class
	 */
         
        public $Accion;
        public $Usuario;
        public $Cabina;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

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
			array('Fecha, Hora, ACCIONLOG_Id, USERS_Id', 'required'),
			//array('Hora', 'compare', 'operator'=>'<=', 'compareValue'=>date('H:m:s'), 'message'=>'No puede declarar una hora mayor a la actual'),
			array('ACCIONLOG_Id', 'numerical', 'integerOnly'=>true),
			array('FechaEsp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, Fecha, Hora, FechaEsp, ACCIONLOG_Id, USERS_Id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
                Yii::app()->getModule('user');
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'aCCIONLOG' => array(self::BELONGS_TO, 'Accionlog', 'ACCIONLOG_Id'),
			'uSERS' => array(self::BELONGS_TO, 'Users', 'USERS_Id'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'ID',
			'Fecha' => 'Fecha',
			'Hora' => 'Hora',
			'FechaEsp' => 'Fecha Esp',
			'ACCIONLOG_Id' => 'Accionlog',
			'USERS_Id' => 'Users',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Id',$this->Id);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('Hora',$this->Hora,true);
		$criteria->compare('FechaEsp',$this->FechaEsp,true);
		//$criteria->compare('ACCIONLOG_Id',$this->ACCIONLOG_Id);
                $criteria->with =array('aCCIONLOG','uSERS');
                $criteria->compare('aCCIONLOG.Id', $this->ACCIONLOG_Id,true);
		//$criteria->compare('USERS_Id',$this->USERS_Id);
                //$criteria->with =array('uSERS');
                $criteria->compare('uSERS.id', $this->USERS_Id,true);
                
                //$request;
//                if(Yii::app()->request->getQuery("user_username")){
//                    $criteria->addCondition("uSERS.id=:user_username");
//                    $criteria->params[':user_username'] = Yii::app()->request->getQuery("user_username");
//                }
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'Fecha DESC'),
		));
	}

}