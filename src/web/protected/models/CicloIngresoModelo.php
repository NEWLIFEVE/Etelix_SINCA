<?php

/**
 * This is the model class for table "ciclo_ingreso".
 *
 * The followings are the available columns in table 'ciclo_ingreso':
 * @property integer $Id
 * @property string $Fecha
 * @property integer $CABINA_Id
 * @property string $DiferencialBancario
 * @property string $ConciliacionBancaria
 * @property string $DiferencialMovistar
 * @property string $DiferencialClaro
 * @property string $DiferencialDirectv
 * @property string $DiferencialNextel
 * @property string $DiferencialCaptura
 * @property string $AcumuladoCaptura
 * @property string $Sobrante
 * @property string $AcumuladoSobrante
 *
 * The followings are the available model relations:
 * @property Cabina $cABINA
 */
class CicloIngresoModelo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    
        public $TotalVentas;
        public $DifFullCarga;
        public $Paridad;
        public $DifSoles;
        public $DifDollar;


        public function tableName()
	{
		return 'ciclo_ingreso';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Fecha, CABINA_Id', 'required'),
			array('CABINA_Id', 'numerical', 'integerOnly'=>true),
			array('DiferencialBancario, ConciliacionBancaria, DiferencialMovistar, DiferencialClaro, DiferencialDirectv, DiferencialNextel, DiferencialCaptura, AcumuladoCaptura, Sobrante, AcumuladoSobrante', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, Fecha, CABINA_Id, DiferencialBancario, ConciliacionBancaria, DiferencialMovistar, DiferencialClaro, DiferencialDirectv, DiferencialNextel, DiferencialCaptura, AcumuladoCaptura, Sobrante, AcumuladoSobrante', 'safe', 'on'=>'search'),
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
			'CABINA_Id' => 'Cabina',
			'DiferencialBancario' => 'Diferencial Bancario',
			'ConciliacionBancaria' => 'Conciliacion Bancaria',
			'DiferencialMovistar' => 'Diferencial Movistar',
			'DiferencialClaro' => 'Diferencial Claro',
			'DiferencialDirectv' => 'Diferencial Directv',
			'DiferencialNextel' => 'Diferencial Nextel',
			'DiferencialCaptura' => 'Diferencial Captura',
			'AcumuladoCaptura' => 'Acumulado Captura',
			'Sobrante' => 'Sobrante',
			'AcumuladoSobrante' => 'Acumulado Sobrante',
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
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('CABINA_Id',$this->CABINA_Id);
		$criteria->compare('DiferencialBancario',$this->DiferencialBancario,true);
		$criteria->compare('ConciliacionBancaria',$this->ConciliacionBancaria,true);
		$criteria->compare('DiferencialMovistar',$this->DiferencialMovistar,true);
		$criteria->compare('DiferencialClaro',$this->DiferencialClaro,true);
		$criteria->compare('DiferencialDirectv',$this->DiferencialDirectv,true);
		$criteria->compare('DiferencialNextel',$this->DiferencialNextel,true);
		$criteria->compare('DiferencialCaptura',$this->DiferencialCaptura,true);
		$criteria->compare('AcumuladoCaptura',$this->AcumuladoCaptura,true);
		$criteria->compare('Sobrante',$this->Sobrante,true);
		$criteria->compare('AcumuladoSobrante',$this->AcumuladoSobrante,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CicloIngreso the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getDifConBancario($fecha,$cabina,$variable) {
            
            $model = self::model()->findBySql("SELECT * FROM ciclo_ingreso WHERE Fecha = '$fecha' AND CABINA_Id = $cabina;");
            if($model != NULL){
                if($variable == 1){
                    return $model->DiferencialBancario;
                }elseif($variable == 2){
                    return $model->ConciliacionBancaria;
                }
            }else{
                return '0';
            }
        }
        
}
