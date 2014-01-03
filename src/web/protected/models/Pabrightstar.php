<?php

/**
 * This is the model class for table "pabrightstar".
 *
 * The followings are the available columns in table 'pabrightstar':
 * @property integer $Id
 * @property string $Fecha
 * @property integer $Compania
 * @property string $SaldoAperturaPA
 * @property string $TransferenciaPA
 * @property string $ComisionPA
 * @property string $SaldoCierrePA
 *
 * The followings are the available model relations:
 * @property Compania $compania
 */
class Pabrightstar extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pabrightstar the static model class
	 */
        public $RecargaPA;
        public $SubtotalPA;
        public $Saldo;
        public $SaldoApertura;
        public $MontoBancoNull;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pabrightstar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Fecha, Compania,TransferenciaPA', 'required'),
			array('Compania', 'numerical', 'integerOnly'=>true),
			array('SaldoAperturaPA, TransferenciaPA, ComisionPA, SaldoCierrePA', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, Fecha, Compania, SaldoAperturaPA, TransferenciaPA, ComisionPA, SaldoCierrePA', 'safe', 'on'=>'search'),
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
			'compania' => array(self::BELONGS_TO, 'Compania', 'Compania'),
			/*'recargas' => array(self::HAS_MANY, 'Recargas', 'PABRIGHTSTAR_Id'),*/
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
			'Compania' => 'Compania',
			'SaldoAperturaPA' => 'Saldo Apertura P.A.',
			'TransferenciaPA' => 'Transferencia P.A.',
			'ComisionPA' => 'Comision P.A.',
			'SaldoCierrePA' => 'Saldo Cierre P.A.',
			'RecargaPA' => 'Recarga P.A.',
			'SubtotalPA' => 'Sub Total P.A.',
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
		$criteria->compare('Compania',$this->Compania);
		$criteria->compare('SaldoAperturaPA',$this->SaldoAperturaPA,true);
		$criteria->compare('TransferenciaPA',$this->TransferenciaPA,true);
		$criteria->compare('ComisionPA',$this->ComisionPA,true);
		$criteria->compare('SaldoCierrePA',$this->SaldoCierrePA,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array('defaultOrder'=>'Fecha DESC'),
		));
	}
	public static function getSaldoPorDia($fecha=null,$compania)
	{
		if($fecha==null)
		{
			$fecha=date("Y-m-d");
		}
//		$sql="SELECT IFNULL(SaldoAperturaPA,0)+IFNULL(TransferenciaPA,0)+IFNULL(ComisionPA,0) AS Saldo FROM pabrightstar WHERE Fecha<='{$fecha}' AND Compania='{$compania}' ORDER BY Fecha DESC LIMIT 1;";
		$sql="SELECT IFNULL(p.SaldoAperturaPA,0)+IFNULL(p.TransferenciaPA,0)+IFNULL(p.ComisionPA,0) - X.SumRecargas AS Saldo 
                      FROM pabrightstar p, (SELECT IFNULL(SUM(r.montoRecarga),0) as SumRecargas 
                                            FROM recargas r, pabrightstar p
                                            WHERE p.Fecha='{$fecha}' AND p.Compania='{$compania}' AND p.Id = r.PABRIGHTSTAR_Id) X 
                      WHERE p.Fecha='{$fecha}' AND p.Compania='{$compania}' ";
		$resultado = self::model()->findBySql($sql);
		if($resultado == NULL)
            return '0.00';
        else
            return $resultado->getAttribute('Saldo');
	}

	public static function getIdPorDia($fecha=null, $compania=null)
	{
		if($fecha==null)
		{
			$fecha=date("Y-m-d");
		}
		$sql="SELECT Id FROM pabrightstar WHERE Fecha<='{$fecha}' and Compania='{$compania}' ORDER BY Fecha DESC LIMIT 0,1;";

		$resultado = self::model()->findBySql($sql);
		if($resultado == NULL)
            return '0';
        else
            return $resultado->getAttribute('Id');
	}
}