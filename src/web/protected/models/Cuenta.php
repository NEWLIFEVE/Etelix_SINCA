<?php

/**
 * This is the model class for table "cuenta".
 *
 * The followings are the available columns in table 'cuenta':
 * @property integer $Id
 * @property string $Nombre
 * @property string $Numero
 * @property integer $moneda
 *
 * The followings are the available model relations:
 * @property Banco[] $bancos
 * @property Detallegasto[] $detallegastos
 */
class Cuenta extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cuenta the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cuenta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Nombre, Numero, moneda', 'required'),
			array('moneda', 'numerical', 'integerOnly'=>true),
			array('Nombre, Numero', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, Nombre, Numero, moneda', 'safe', 'on'=>'search'),
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
			'bancos' => array(self::HAS_MANY, 'Banco', 'CUENTA_Id'),
			'detallegastos' => array(self::HAS_MANY, 'Detallegasto', 'CUENTA_Id'),
			'balances' => array(self::HAS_MANY, 'Balance', 'CUENTA_Id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'ID',
			'Nombre' => 'Nombre',
			'Numero' => 'Numero',
			'moneda' => 'Moneda',
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
		$criteria->compare('Nombre',$this->Nombre,true);
		$criteria->compare('Numero',$this->Numero,true);
		$criteria->compare('moneda',$this->moneda);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
	/**
	*
	*/
    public static function getListCuentaTipo($tipo)
	{
		return CHtml::listData(Cuenta::model()->findAll('moneda=:moneda',array(':moneda'=>$tipo)), 'Id', 'Nombre');
	}

	/**
	* Consigue la lista de cuentas exitentes
	* @return array.
	*/
	public static function getListCuenta()
	{
		return CHtml::listData(Cuenta::model()->findAll(), 'Id', 'Nombre');
	}
     
    /**
    *
    */
    public static function validateCuentaNombre($cuenta)
    {
    	if (is_null($cuenta))
    	{
    		return 'No asignado';
    	}
    	else
    	{
    		$model = self::model()->find('Id=:cuenta', array(':cuenta'=>$cuenta));
    		return $model->Nombre;
    	}
    }
}