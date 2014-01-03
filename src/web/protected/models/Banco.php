<?php

/**
 * This is the model class for table "banco".
 *
 * The followings are the available columns in table 'banco':
 * @property integer $Id
 * @property string $Fecha
 * @property string $SaldoApBanco
 * @property string $SaldoCierreBanco
 * @property string $CUENTA_Id
 */
class Banco extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Banco the static model class
	 */
        public $IngresoBanco;
        public $EgresoBanco;
        public $SubtotalBanco;
        public $SaldoLibro;
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'banco';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Fecha, SaldoApBanco', 'required'),
			array('SaldoApBanco, SaldoCierreBanco', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, Fecha, SaldoApBanco, SaldoCierreBanco,CUENTA_Id', 'safe', 'on'=>'search'),
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
			'SaldoApBanco' => 'Saldo Apertura',
			'SaldoCierreBanco' => 'Saldo Cierre',
                        'IngresoBanco' => 'Ingresos',
                        'EgresoBanco' => 'Egresos',
                        'SubtotalBanco' => 'Sub Total',
                        'CUENTA_Id' => 'Cuenta',
                        'SaldoLibro' => 'Saldo Libro',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($post=null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition="Id>0";
		$criteria->compare('Id',$this->Id);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('SaldoApBanco',$this->SaldoApBanco,true);
		$criteria->compare('SaldoCierreBanco',$this->SaldoCierreBanco,true);
		$criteria->compare('CUENTA_Id',$this->CUENTA_Id,true);
		//Cambio la condicion dependiendo de los valores
        if(isset($post['formFecha']))
        {
            $criteria->condition.=" AND Fecha<='".$post['formFecha']."-31' AND Fecha>='".$post['formFecha']."-01'";
        }
        if(isset($post['formCuenta']))
        {
            $criteria->condition.=" AND CUENTA_Id=".$post['formCuenta'];
        }
        //la paginacion
        $pagina=Cuenta::model()->count('Id>0');
        $orden="Fecha DESC";
        
        if(isset($post['formFecha']) || isset($post['formCuenta']))
        {
            $condition="Id>0";
            if($post['formFecha'])
            {
                $condition.=" AND Fecha<='".$post['formFecha']."-31' AND Fecha>='".$post['formFecha']."-01'";
            }
            if($post['formCuenta'])
            {
                $condition.=" AND CUENTA_Id=".$post['formCuenta'];
            }
            $pagina=Balance::model()->count($condition);
            $orden="Fecha ASC";
        }
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'sort'=>array('defaultOrder'=>$orden),
                'pagination'=>array('pageSize'=>$pagina),
            ));
	}
}