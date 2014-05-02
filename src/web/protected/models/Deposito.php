<?php

/**
 * This is the model class for table "deposito".
 *
 * The followings are the available columns in table 'deposito':
 * @property integer $id
 * @property string $Fecha
 * @property string $Hora
 * @property string $MontoDep
 * @property string $MontoBanco
 * @property string $NumRef
 * @property string $Depositante
 * @property integer $CUENTA_Id
 * @property integer $CABINA_Id
 *
 * The followings are the available model relations:
 * @property Cuenta $cUENTA
 * @property Cabina $cABINA
 */
class Deposito extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'deposito';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Fecha, Hora, MontoDep, NumRef, CUENTA_Id, CABINA_Id', 'required'),
			array('CUENTA_Id, CABINA_Id', 'numerical', 'integerOnly'=>true),
			array('MontoDep, MontoBanco', 'length', 'max'=>15),
			array('NumRef, Depositante', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, Fecha, Hora, MontoDep, MontoBanco, NumRef, Depositante, CUENTA_Id, CABINA_Id', 'safe', 'on'=>'search'),
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
			'cUENTA' => array(self::BELONGS_TO, 'Cuenta', 'CUENTA_Id'),
			'cABINA' => array(self::BELONGS_TO, 'Cabina', 'CABINA_Id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'Fecha' => 'Fecha',
			'Hora' => 'Hora',
			'MontoDep' => 'Monto Dep',
			'MontoBanco' => 'Monto Banco',
			'NumRef' => 'Num Ref',
			'Depositante' => 'Depositante',
			'CUENTA_Id' => 'Cuenta',
			'CABINA_Id' => 'Cabina',
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
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('Hora',$this->Hora,true);
		$criteria->compare('MontoDep',$this->MontoDep,true);
		$criteria->compare('MontoBanco',$this->MontoBanco,true);
		$criteria->compare('NumRef',$this->NumRef,true);
		$criteria->compare('Depositante',$this->Depositante,true);
		$criteria->compare('CUENTA_Id',$this->CUENTA_Id);
		$criteria->compare('CABINA_Id',$this->CABINA_Id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Deposito the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
