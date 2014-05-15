<?php

/**
 * This is the model class for table "saldo_cabina".
 *
 * The followings are the available columns in table 'saldo_cabina':
 * @property integer $Id
 * @property string $SaldoAp
 * @property string $SaldoCierre
 * @property string $Fecha
 * @property integer $CABINA_Id
 * @property integer $COMPANIA_Id
 *
 * The followings are the available model relations:
 * @property Cabina $cABINA
 * @property Compania $cOMPANIA
 */
class SaldoCabina extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'saldo_cabina';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('SaldoAp, Fecha, CABINA_Id, COMPANIA_Id', 'required'),
			array('CABINA_Id, COMPANIA_Id', 'numerical', 'integerOnly'=>true),
			array('SaldoAp, SaldoCierre', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, SaldoAp, SaldoCierre, Fecha, CABINA_Id, COMPANIA_Id', 'safe', 'on'=>'search'),
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
			'cABINA' => array(self::BELONGS_TO, 'Cabina', 'CABINA_Id'),
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
			'SaldoAp' => 'Saldo Apertura',
			'SaldoCierre' => 'Saldo Cierre',
			'Fecha' => 'Fecha del Balance',
			'CABINA_Id' => 'Cabina',
			'COMPANIA_Id' => 'Compania',
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

		$criteria->compare('Id',$this->Id);
		$criteria->compare('SaldoAp',$this->SaldoAp,true);
		$criteria->compare('SaldoCierre',$this->SaldoCierre,true);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('CABINA_Id',$this->CABINA_Id);
		$criteria->compare('COMPANIA_Id',$this->COMPANIA_Id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SaldoCabina the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getSaldoAp($fecha,$cabina)
	{
            $model = self::model()->findBySql("SELECT SUM(SaldoAp) as SaldoAp
                                               FROM saldo_cabina 
                                               WHERE Fecha = '$fecha' AND CABINA_Id = $cabina;");
            if($model->SaldoAp != NULL)
                return $model->SaldoAp;
            else
                return '0.00';
	}
}
