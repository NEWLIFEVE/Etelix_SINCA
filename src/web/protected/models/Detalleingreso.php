<?php

/**
 * This is the model class for table "detalleingreso".
 *
 * The followings are the available columns in table 'detalleingreso':
 * @property integer $Id
 * @property string $Monto
 * @property string $FechaMes
 * @property string $Descripcion
 * @property string $TransferenciaPago
 * @property string $FechaTransf
 * @property integer $moneda
 * @property integer $USERS_Id
 * @property integer $TIPOINGRESO_Id
 * @property integer $CABINA_Id
 * @property integer $CUENTA_Id
 *
 * The followings are the available model relations:
 * @property Currency $moneda0
 * @property Cabina $cABINA
 * @property Cuenta $cUENTA
 * @property TipoIngresos $tIPOINGRESO
 * @property Users $uSERS
 */
class Detalleingreso extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public $nombreTipoDetalle;
        public $Cabina;
        public $Tipoingreso;
        public $Cuenta;


        public function tableName()
	{
		return 'detalleingreso';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CABINA_Id, CUENTA_Id, moneda, Monto, FechaMes, USERS_Id, TIPOINGRESO_Id', 'required'),
			array('Id, moneda, USERS_Id, TIPOINGRESO_Id, CABINA_Id, CUENTA_Id', 'numerical', 'integerOnly'=>true),
			array('Monto', 'length', 'max'=>15),
			array('Descripcion', 'length', 'max'=>245),
			array('TransferenciaPago', 'length', 'max'=>35),
			array('FechaTransf', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, Monto, FechaMes, Descripcion, TransferenciaPago, FechaTransf, moneda, USERS_Id, TIPOINGRESO_Id, CABINA_Id, CUENTA_Id', 'safe', 'on'=>'search'),
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
			'moneda0' => array(self::BELONGS_TO, 'Currency', 'moneda'),
			'cABINA' => array(self::BELONGS_TO, 'Cabina', 'CABINA_Id'),
			'cUENTA' => array(self::BELONGS_TO, 'Cuenta', 'CUENTA_Id'),
			'tIPOINGRESO' => array(self::BELONGS_TO, 'TipoIngresos', 'TIPOINGRESO_Id'),
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
			'Monto' => 'Monto',
			'FechaMes' => 'Mes',
			'Descripcion' => 'Descripcion',
			'TransferenciaPago' => 'Nro. Transferencia',
			'FechaTransf' => 'Fecha Transferencia',
			'moneda' => 'Moneda',
			'USERS_Id' => 'Responsable',
			'TIPOINGRESO_Id' => 'Tipo de Ingreso',
			'CABINA_Id' => 'Cabina',
			'CUENTA_Id' => 'Cuenta',
                        'nombreTipoDetalle' => 'Nombre Tipo Ingreso',
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
	public function search($cabina=null,$mes=null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Id',$this->Id);
		$criteria->compare('Monto',$this->Monto,true);
		$criteria->compare('FechaMes',$this->FechaMes,true);
		$criteria->compare('Descripcion',$this->Descripcion,true);
		$criteria->compare('TransferenciaPago',$this->TransferenciaPago,true);
		$criteria->compare('FechaTransf',$this->FechaTransf,true);
		$criteria->compare('moneda',$this->moneda);
		$criteria->compare('USERS_Id',$this->USERS_Id);
		$criteria->compare('TIPOINGRESO_Id',$this->TIPOINGRESO_Id);
		$criteria->compare('CABINA_Id',$this->CABINA_Id);
		$criteria->compare('CUENTA_Id',$this->CUENTA_Id);
                
                if($cabina!=NULL)
                    $criteria->addCondition("CABINA_Id=$cabina");
                if($mes!=NULL)
                    $criteria->addCondition("FechaMes='$mes'");

                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Detalleingreso the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
