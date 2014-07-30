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
    
        public $TotalVentas;
        public $DifFullCarga;
        public $Paridad;
        public $DifSoles;
        public $DifDollar;
    
	/**
	 * @return string the associated database table name
	 */
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
        
        public static function getDifConBancario($fecha,$cabina=NULL,$variable) {
            
            
            if($cabina != NULL){
                $model = self::model()->findBySql("SELECT SUM(IFNULL(DiferencialBancario,0)) as DiferencialBancario, SUM(IFNULL(ConciliacionBancaria,0)) as ConciliacionBancaria FROM ciclo_ingreso WHERE Fecha = '$fecha' AND CABINA_Id = $cabina;");
            }else{
                if($variable == 1){
                    $model = self::model()->findBySql("SELECT SUM(IFNULL(DiferencialBancario,0)) as DiferencialBancario FROM ciclo_ingreso WHERE Fecha = '$fecha';");
                }elseif($variable == 2){
                    $model = self::model()->findBySql("SELECT SUM(IFNULL(ConciliacionBancaria,0)) as ConciliacionBancaria FROM ciclo_ingreso WHERE Fecha = '$fecha';");
                }
            }
            
            if($model != NULL){
                if($variable == 1){
                    return ($model->DiferencialBancario != NULL) ? $model->DiferencialBancario : '0.00';
                }elseif($variable == 2){
                    return ($model->ConciliacionBancaria != NULL) ? $model->ConciliacionBancaria : '0.00';
                }
            }else{
                return '0.00';
            }
        }
        
        public static function getDifFullCarga($fecha,$cabina=NULL,$compania) {
            
            
            if($cabina != NULL){
                $model = self::model()->findBySql("SELECT SUM(DiferencialMovistar) as DiferencialMovistar,
                                                    SUM(DiferencialClaro) as DiferencialClaro,
                                                    SUM(DiferencialNextel) as DiferencialNextel,
                                                    SUM(DiferencialDirectv) as DiferencialDirectv
                                                    FROM ciclo_ingreso WHERE Fecha = '$fecha' AND CABINA_Id = $cabina;");
            }else{
                $model = self::model()->findBySql("SELECT SUM(DiferencialMovistar) as DiferencialMovistar,
                                                    SUM(DiferencialClaro) as DiferencialClaro,
                                                    SUM(DiferencialNextel) as DiferencialNextel,
                                                    SUM(DiferencialDirectv) as DiferencialDirectv
                                                    FROM ciclo_ingreso WHERE Fecha = '$fecha';");
            }
            
            if($model != NULL){
                if($compania == 1){
                    return ($model->DiferencialMovistar != NULL) ? $model->DiferencialMovistar : '0.00';
                }elseif($compania == 2){
                    return ($model->DiferencialClaro != NULL) ? $model->DiferencialClaro : '0.00';
                }elseif($compania == 3){
                    return ($model->DiferencialNextel != NULL) ? $model->DiferencialNextel : '0.00';
                }elseif($compania == 4){
                    return ($model->DiferencialDirectv != NULL) ? $model->DiferencialDirectv : '0.00';
                }
            }else{
                return '0.00';
            }
        }
        
        public static function getDifCaptura($fecha,$cabina=NULL,$moneda) {
            
            $primero_mes = date('Y-m', strtotime($fecha)).'-01';
            
            if($cabina != NULL){
                
                $model = self::model()->findBySql("SELECT SUM(IFNULL(DiferencialCaptura,0)) as DiferencialCaptura FROM ciclo_ingreso WHERE Fecha = '$fecha' AND CABINA_Id = $cabina;");
                $Acumulado = self::model()->findBySql("SELECT SUM(IFNULL(DiferencialCaptura,0)) as AcumuladoSobrante FROM ciclo_ingreso WHERE Fecha >= '$primero_mes' AND Fecha <= '$fecha' AND CABINA_Id = $cabina;");

            }else{
                
                $model = self::model()->findBySql("SELECT SUM(IFNULL(DiferencialCaptura,0)) as DiferencialCaptura FROM ciclo_ingreso WHERE Fecha = '$fecha';");
                $Acumulado = self::model()->findBySql("SELECT SUM(IFNULL(DiferencialCaptura,0)) as AcumuladoSobrante FROM ciclo_ingreso WHERE Fecha >= '$primero_mes' AND Fecha <= '$fecha';");

            }
            
            $paridad = Paridad::getParidad($fecha);
            
            if($model != NULL){
                
                if($moneda == 1){
                    return ($model->DiferencialCaptura != NULL) ? $model->DiferencialCaptura : '0.00';
                }elseif($moneda == 2){
                    return ($model->DiferencialCaptura != NULL) ? number_format($model->DiferencialCaptura*$paridad, 2, '.', '') : '0.00';
                }elseif($moneda == 3){

                    return ($Acumulado != NULL) ? ($Acumulado->AcumuladoSobrante) : '0.00';

                }
                
            }else{
                if($moneda == 3){
                    
                    return ($Acumulado != NULL) ? ($Acumulado->AcumuladoSobrante) : '0.00';

                }else{
                    return '0.00';
                }
            }
        }
        
        public static function getSobrante($fecha,$cabina=NULL,$acumulado){
            
            $primero_mes = date('Y-m', strtotime($fecha)).'-01';

            if($cabina != NULL){
                $model = self::model()->findBySql("SELECT SUM(IFNULL(DiferencialBancario,0)) as DiferencialBancario,
                                                       SUM(IFNULL(DiferencialMovistar,0)) as DiferencialMovistar,
                                                       SUM(IFNULL(DiferencialClaro,0)) as DiferencialClaro,
                                                       SUM(IFNULL(DiferencialNextel,0)) as DiferencialNextel,
                                                       SUM(IFNULL(DiferencialDirectv,0)) as DiferencialDirectv,
                                                       SUM(IFNULL(DiferencialCaptura,0)) as DiferencialCaptura
                                                       FROM ciclo_ingreso WHERE Fecha = '$fecha' AND CABINA_Id = $cabina;");
                
                $modelAcum = self::model()->findBySql("SELECT SUM(IFNULL(DiferencialBancario,0)) as DiferencialBancario,
                                                       SUM(IFNULL(DiferencialMovistar,0)) as DiferencialMovistar,
                                                       SUM(IFNULL(DiferencialClaro,0)) as DiferencialClaro,
                                                       SUM(IFNULL(DiferencialNextel,0)) as DiferencialNextel,
                                                       SUM(IFNULL(DiferencialDirectv,0)) as DiferencialDirectv,
                                                       SUM(IFNULL(DiferencialCaptura,0)) as DiferencialCaptura
                                                       FROM ciclo_ingreso 
                                                       WHERE Fecha >= '$primero_mes' 
                                                       AND Fecha <= '$fecha' 
                                                       AND CABINA_Id = $cabina;");
            }else{
                $model = self::model()->findBySql("SELECT SUM(IFNULL(DiferencialBancario,0)) as DiferencialBancario,
                                                   SUM(IFNULL(DiferencialMovistar,0)) as DiferencialMovistar,
                                                   SUM(IFNULL(DiferencialClaro,0)) as DiferencialClaro,
                                                   SUM(IFNULL(DiferencialNextel,0)) as DiferencialNextel,
                                                   SUM(IFNULL(DiferencialDirectv,0)) as DiferencialDirectv,
                                                   SUM(IFNULL(DiferencialCaptura,0)) as DiferencialCaptura
                                                   FROM ciclo_ingreso WHERE Fecha = '$fecha';");
                
                $modelAcum = self::model()->findBySql("SELECT SUM(IFNULL(DiferencialBancario,0)) as DiferencialBancario,
                                                   SUM(IFNULL(DiferencialMovistar,0)) as DiferencialMovistar,
                                                   SUM(IFNULL(DiferencialClaro,0)) as DiferencialClaro,
                                                   SUM(IFNULL(DiferencialNextel,0)) as DiferencialNextel,
                                                   SUM(IFNULL(DiferencialDirectv,0)) as DiferencialDirectv,
                                                   SUM(IFNULL(DiferencialCaptura,0)) as DiferencialCaptura
                                                   FROM ciclo_ingreso 
                                                   WHERE Fecha >= '$primero_mes' 
                                                   AND Fecha <= '$fecha';");;
            }

            $paridad = Paridad::getParidad($fecha);
            
            
            
            if($acumulado == false){
                //SOBRANTE
                if($model != NULL){

                    return number_format((($model->DiferencialBancario+$model->DiferencialMovistar+$model->DiferencialClaro+$model->DiferencialNextel+$model->DiferencialDirectv+($model->DiferencialCaptura*$paridad))/$paridad), 2, '.', '');

                }else{
                    return '0.00';
                }
                
            }elseif($acumulado == true){
                //SOBRANTE ACUMULADO
                if($modelAcum != NULL){

                    return number_format((($modelAcum->DiferencialBancario+$modelAcum->DiferencialMovistar+$modelAcum->DiferencialClaro+$modelAcum->DiferencialNextel+$modelAcum->DiferencialDirectv+($modelAcum->DiferencialCaptura*$paridad))/$paridad), 2, '.', '');

                }else{
                    return '0.00';
                }
            }
            
        }
        
        public static function saveCicloIngreso($fecha,$cabinaId) {
            
            $newModelCI = new CicloIngresoModelo;
            $newModelCI->Fecha = $fecha;
            $newModelCI->CABINA_Id = $cabinaId;   
            $newModelCI->save();
            
        }
        
        public static function saveDifCaptura($fecha,$cabinaId,$montoSoriRevenue,$paridad) {
            
            $ventasTrafico = Detalleingreso::getLibroVentas("LibroVentas","trafico", $fecha,$cabinaId);                                       
            $modeCicloIngreso = self::model()->find("Fecha = '$fecha' AND CABINA_Id = $cabinaId");
            if($modeCicloIngreso != NULL){
                $modeCicloIngreso->DiferencialCaptura = round(($ventasTrafico-$montoSoriRevenue*$paridad)/$paridad,2);
                $modeCicloIngreso->AcumuladoCaptura = Detalleingreso::getAcumulado($fecha,$cabinaId);
                $modeCicloIngreso->save();
            }elseif($modeCicloIngreso == NULL){
                $newModelCI = new CicloIngresoModelo;
                $newModelCI->Fecha = $fecha;
                $newModelCI->CABINA_Id = $cabinaId;   
                $newModelCI->DiferencialCaptura = round(($ventasTrafico-$montoSoriRevenue*$paridad)/$paridad,2);
                $newModelCI->AcumuladoCaptura = Detalleingreso::getAcumulado($fecha,$cabinaId);
                $newModelCI->save();

            }
            
        }
        
}