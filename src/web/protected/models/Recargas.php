<?php

/**
 * This is the model class for table "recargas".
 *
 * The followings are the available columns in table 'recargas':
 * @property integer $id
 * @property string $FechaHora
 * @property string $MontoRecarga
 * @property integer $BALANCE_Id
 * @property integer $PABRIGHTSTAR_Id
 *
 * The followings are the available model relations:
 * @property Balance $bALANCE
 * @property Pabrightstar $pABRIGHTSTAR
 */
class Recargas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Recargas the static model class
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
		return 'recargas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('FechaHora, MontoRecarga, BALANCE_Id, PABRIGHTSTAR_Id', 'required'),
			array('BALANCE_Id, PABRIGHTSTAR_Id', 'numerical', 'integerOnly'=>true),
			array('MontoRecarga', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, FechaHora, MontoRecarga, BALANCE_Id, PABRIGHTSTAR_Id', 'safe', 'on'=>'search'),
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
			'bALANCE' => array(self::BELONGS_TO, 'Balance', 'BALANCE_Id'),
			'pABRIGHTSTAR' => array(self::BELONGS_TO, 'Pabrightstar', 'PABRIGHTSTAR_Id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'FechaHora' => 'Fecha Hora',
			'MontoRecarga' => 'Monto Recarga',
			'BALANCE_Id' => 'Balance',
			'PABRIGHTSTAR_Id' => 'Pabrightstar',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('FechaHora',$this->FechaHora,true);
		$criteria->compare('MontoRecarga',$this->MontoRecarga,true);
		$criteria->compare('BALANCE_Id',$this->BALANCE_Id);
		$criteria->compare('PABRIGHTSTAR_Id',$this->PABRIGHTSTAR_Id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/*
	* Metodo encargado de calcular las recargas por cabina
	* 
	* parametros:
	*   int cabina = el id de la cabina
	*   string compania = el nombre de la compania
	*   date fecha = fecha de cuando se necesita la recarga
	*
	* returna un string con el monto
	*/
	public static function getMontoRecarga($cabina,$compania,$fecha)
	{
		$sql="SELECT IFNULL(SUM(MontoRecarga),0) AS MontoRecarga FROM recargas WHERE BALANCE_Id=(SELECT Id FROM balance WHERE CABINA_Id='{$cabina}' AND Fecha='{$fecha}' ORDER BY Id DESC LIMIT 1) AND PABRIGHTSTAR_Id=(SELECT Id FROM pabrightstar WHERE Compania=(SELECT id FROM compania WHERE nombre='{$compania}') AND Fecha<='{$fecha}' ORDER BY Fecha DESC LIMIT 1);";
        $resultado = self::model()->findBySql($sql);
        if($resultado->getAttribute('MontoRecarga') == NULL)
            return '0.00';
        else
            return $resultado->getAttribute('MontoRecarga');
	}
	public static function getMontoRecargaPorDia($fecha=null,$pabrightstar)
	{
		if($fecha==null)
		{
			$fecha=date("Y-m-d");
		}
		$sql="SELECT IFNULL(SUM(MontoRecarga),0) AS MontoRecarga FROM recargas WHERE FechaHora >= '{$fecha}' AND PABRIGHTSTAR_Id='{$pabrightstar}';";
		$resultado = self::model()->findBySql($sql);
		if($resultado->getAttribute('MontoRecarga') == NULL)
            return '0.00';
        else
            return $resultado->getAttribute('MontoRecarga');
	}
}