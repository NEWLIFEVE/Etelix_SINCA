<?php

/**
 * This is the model class for table "novedad".
 *
 * The followings are the available columns in table 'novedad':
 * @property integer $Id
 * @property string $Fecha
 * @property string $Hora
 * @property string $Descripcion
 * @property string $Num
 * @property string $Puesto
 * @property integer $users_id
 * @property integer $TIPONOVEDAD_Id
 *
 * The followings are the available model relations:
 * @property Tiponovedad $nOVEDAD
 * @property Users $users
 */
class Novedad extends CActiveRecord
{
    public $User;
    public $TipoNovedad;


    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'novedad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Descripcion, users_id, TIPONOVEDAD_Id, Puesto', 'required'),        
			array('users_id, TIPONOVEDAD_Id, Num, Puesto', 'numerical', 'integerOnly'=>true),
			array('Descripcion', 'length', 'max'=>450),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Fecha, Hora, Id, Descripcion, Num, Puesto, users_id, TIPONOVEDAD_Id', 'safe', 'on'=>'search'),
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
			'tIPONOVEDAD' => array(self::BELONGS_TO, 'Tiponovedad', 'TIPONOVEDAD_Id'),
			'users' => array(self::BELONGS_TO, 'Users', 'users_id'),
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
			'Descripcion' => 'Descripción',
			'Num' => 'Número Telefonico',
                        'Puesto'=>'Puesto de la Cabina',
			'users_id' => 'Usuario',
			'TIPONOVEDAD_Id' => 'Tipo de Novedad',
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
                $criteria->compare('Fecha',$this->Fecha);
		$criteria->compare('Hora',$this->Hora);
		$criteria->compare('Descripcion',$this->Descripcion,true);
		$criteria->compare('Num',$this->Num,true);
		$criteria->compare('Puesto',$this->Puesto,true);
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('TIPONOVEDAD_Id',$this->TIPONOVEDAD_Id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array('defaultOrder'=>'Fecha DESC'),
		));
	}
        
        public function searchEs($vista=null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Id',$this->Id);
		$criteria->compare('Fecha',$this->Fecha);
		$criteria->compare('Hora',$this->Hora);
		$criteria->compare('Descripcion',$this->Descripcion,true);
		$criteria->compare('Num',$this->Num,true);
                $criteria->compare('Puesto',$this->Puesto,true);
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('TIPONOVEDAD_Id',$this->TIPONOVEDAD_Id);

                if($vista=='admin')
                {
                    if(Yii::app()->getModule('user')->user()->tipo==1){
                        $criteria->addCondition("users_id=".Yii::app()->getModule('user')->user()->id);
                    }    
                }
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array('defaultOrder'=>'Fecha DESC'),
		));
	}
        
}