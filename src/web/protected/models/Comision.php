<?php

/**
 * This is the model class for table "comision".
 *
 * The followings are the available columns in table 'comision':
 * @property integer $Id
 * @property string $Fecha
 * @property string $Valor
 * @property integer $COMPANIA_Id
 *
 * The followings are the available model relations:
 * @property Compania $cOMPANIA
 */
class Comision extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comision the static model class
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
		return 'comision';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Fecha, Valor, COMPANIA_Id', 'required'),
			array('COMPANIA_Id', 'numerical', 'integerOnly'=>true),
			array('Valor', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, Fecha, Valor, COMPANIA_Id', 'safe', 'on'=>'search'),
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
			'cOMPANIA' => array(self::BELONGS_TO, 'Compania', 'COMPANIA_Id'),
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
			'Valor' => 'Valor',
			'COMPANIA_Id' => 'Compania',
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
		$criteria->compare('Valor',$this->Valor,true);
		$criteria->compare('COMPANIA_Id',$this->COMPANIA_Id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    public static function getUltimaComision($idCompania=null)
    {
//    	if($fecha==null)
//		{
//			$fecha=date("Y-m-d");
//		}
//
//    	$sql="SELECT IFNULL(Valor,1) AS Valor FROM comision WHERE Fecha<='2013-06-05' AND COMPANIA_Id='1' ORDER BY Fecha DESC LIMIT 0,1;";
//    	$resultado = self::model()->findBySql($sql);

    	$resultado = self::model()->find('Fecha<=CURDATE() AND COMPANIA_Id=:compania ORDER BY Fecha DESC LIMIT 1;', array(':compania'=>$idCompania));
        if($resultado == NULL)
        	return "1.00";
        else
        	return $resultado->getAttribute('Valor');
    }
}