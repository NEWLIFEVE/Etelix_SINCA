<?php

/**
 * This is the model class for table "paridad".
 *
 * The followings are the available columns in table 'paridad':
 * @property integer $Id
 * @property string $Fecha
 * @property string $Valor
 *
 * The followings are the available model relations:
 * @property Balance[] $balances
 */
class Paridad extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Paridad the static model class
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
		return 'paridad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Fecha, Valor', 'required'),
			array('Valor', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, Fecha, Valor', 'safe', 'on'=>'search'),
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
			'balances' => array(self::HAS_MANY, 'Balance', 'PARIDAD_Id'),
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getParidad($fecha)
	{
            $model = self::model()->findBySql("SELECT Valor
                                               FROM paridad 
                                               WHERE Fecha <= '$fecha' ORDER BY Fecha DESC LIMIT 1;");
            if($model->Valor != NULL)
                return $model->Valor;
            else
                return '0.00';
	}
}