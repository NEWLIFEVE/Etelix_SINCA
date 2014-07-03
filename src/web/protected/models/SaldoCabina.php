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
    
        public $Cabina; 
        public $OtrosServicios;
        public $OtrosServiciosFullCarga;
        public $Trafico;
        public $RecargaMovistar;
        public $RecargaClaro;
        public $TotalVentas;
        public $TotalVentasDep;


        public $ServMov;
        public $ServClaro;
        public $ServDirecTv;
        public $ServNextel;
        
        public $SaldoCierre;
        public $MontoDeposito;
        public $DiferencialBan;
        public $ConciliacionBan;
        public $Paridad;
        
        public $FijoLocal;
        public $FijoProvincia;
        public $FijoLima;
        public $Rural;
        public $Celular;
        public $LDI;
        
        public $RecargaCelularMov;
        public $RecargaFonoYaMov;
        public $RecargaCelularClaro;
        public $RecargaFonoClaro;
    
        public $DifMov;
        public $DifClaro;
        public $DifDirecTv;
        public $DifNextel;
        public $DifFullCarga;
        
        public $MontoDep;
        public $MontoBanco;
        public $NumRef;
        public $DiferencialBancario;
        public $ConciliacionBancaria;
        public $FechaCorrespondiente;


        public $DifSoles;
        public $DifDollar;
        
        public $TraficoCapturaDollar;
        public $Acumulado;
        public $Sobrante;
        public $SobranteAcum;
        
        public $Total;
        public $DifBancoCI;
        public $ConciliacionBancariaCI;
        public $tagTodasLasCabina='Todas';
        public $CaptSoles;

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
			array('CABINA_Id, COMPANIA_Id, SaldoAp, SaldoCierre', 'numerical', 'integerOnly'=>true),
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
                        'ServMov' => 'Servicios Movistar (S/.)',
                        'ServClaro' => 'Servicios Claro (S/.)',
                        'ServDirecTv' => 'Servicios DirecTv (S/.)',
                        'ServNextel' => 'Servicios Nextel (S/.)',
                        'Trafico' => 'Trafico (S/.)',
                        'TraficoCapturaDollar' => 'Trafico Captura Dollar (S/.)',
                        'OtrosServicios' => 'Otros Servicios (S/.)',
                        'OtrosServiciosFullCarga' => 'Otros Servicios FullCarga (S/.)',
                        'TotalVentas' => 'Total Ventas (S/.)',
                        'TotalVentasDep' => "Total Ventas (S/.) 'A'",
                        'SaldoAp' => 'Saldo Apertura (S/.)',
                        'SaldoCierre' => 'Saldo Cierre (S/.)',
                        'MontoDeposito' => 'Monto Deposito (S/.)',
                        'DiferencialBan' => 'Diferencial Bancario (S/.)',
                        'ConciliacionBan' => 'Consiliacion Bancaria (S/.)',
                        'Paridad'=>'Paridad Cambiaria (S/.|$)',
                        'DifMov'=>'Diferencial Movistar (S/.)',
                        'DifClaro'=>'Diferencial Claro (S/.)',
                        'DifDirecTv'=>'Diferencial DirecTv (S/.)',
                        'DifNextel'=>'Diferencial Nextel (S/.)',
                        'DifSoles'=>"Diferencial Captura Soles (S/.)",
                        'CaptSoles'=>"Diferencial Captura Soles (S/.)",
                        'DifDollar'=>"Diferencial Captura Dollar (USD $)",
                        'Acumulado'=>'Acumulado Dif. Captura (USD $)',
                        'Sobrante'=>'Sobrante (USD $)',
                        'SobranteAcum'=>'Sobrante Acumulado (USD $)',
                        'Ventas'=>'Ventas por Compañia',
                        'FechaBalance'=>'Fecha del Balance',
                        'DifFullCarga'=>'Diferencial FullCarga',
                        'FijoLocal'=>'Fijo Local (S/.)',
                        'FijoProvincia'=>'Fijo Provincia (S/.)',
                        'FijoLima'=>'Fijo Lima (S/.)',
                        'Celular'=>'Celular (S/.)',
                        'Rural'=>'Rural (S/.)',
                        'LDI'=>'LDI (S/.)',
                        'CaptSoles'=>'Captura Soles',
                        'FechaCorrespondiente' => 'Fecha del Balance',
			'Hora' => 'Hora',
			'MontoDep' => "Monto Deposito (S/.) 'B'",
			'MontoBanco' => "Monto Banco (S/.) 'C'",
			'NumRef' => 'Numero de Ref. Deposito',
			'Depositante' => 'Depositante',
                        'DiferencialBancario' => "Diferencial Bancario (S/.) 'C-A'",
                        'ConciliacionBancaria' => "Conciliacion Bancario (S/.) 'C-B'",
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
	public function search($post=null,$mes=null,$cabina=null,$idBalancesActualizados=NULL)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Id',$this->Id);
		$criteria->compare('SUM(SaldoAp)',$this->SaldoAp,true);
		$criteria->compare('SaldoCierre',$this->SaldoCierre,true);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('CABINA_Id',$this->CABINA_Id);
		$criteria->compare('COMPANIA_Id',$this->COMPANIA_Id);
                $criteria->select = "SUM(SaldoAp) as SaldoAp, CABINA_Id, Fecha";
                $criteria->with =array('cABINA');
                $criteria->addCondition("cABINA.status = 1 AND cABINA.Id != 18 AND cABINA.Id != 19");
                $criteria->group='Fecha,CABINA_Id';
                
                if($cabina!=NULL){
                    $criteria->addCondition("CABINA_Id=$cabina");
                }
                
                if($mes!=NULL){
                    $criteria->addCondition("Fecha<='".$mes."-31' AND Fecha>='".$mes."-01'");
                }
                
                $pagina=Cabina::model()->count(array(
                        'condition'=>'status=:status AND Id!=:Id AND Id!=:Id2',
                        'params'=>array(
                            ':status'=>1,
                            ':Id'=>18,
                            ':Id2'=>19,
                            ),
                        ));
		$orden="Fecha DESC, cABINA.Nombre ASC";
                
                if($post == 'cicloIngresoTotal' && $idBalancesActualizados == NULL)
                {
                    
                    $criteriaAux=new CDbCriteria;
                    $criteriaAux->with =array('cABINA');
                    $criteriaAux->addCondition("cABINA.status = 1 AND cABINA.Id != 18 AND cABINA.Id != 19");
                    $criteriaAux->group = "Fecha";
                    
                    $pagina=31;
                    
                    if($mes!=NULL){
                        $criteriaAux->addCondition("Fecha<='".$mes."-31' AND Fecha>='".$mes."-01'");
                    }    
                    
                    if(isset($mes) || isset($cabina))
                    {
                        $condition="Id>0";
                        if($mes)
                        {
                            $condition.=" AND Fecha<='".$mes."-31' AND Fecha>='".$mes."-01'";
                        }
                        if($cabina)
                        {
                            $condition.=" AND CABINA_Id=".$cabina;
                        }
                        $pagina=self::model()->count($condition);

                        if($post == 'admin')
                            $pagina=NULL;

                        $orden="Fecha DESC, cABINA.Nombre ASC";
                    }

                    
                    return new CActiveDataProvider($this, array(
                        'criteria'=>$criteriaAux,
                        'sort'=>array(
                            'defaultOrder'=>'Fecha DESC'
                            ),
                        'pagination'=>array(
                            'pageSize'=>$pagina
                            ),
                        ));
                }
                elseif($post == 'cicloIngresoTotal' && $idBalancesActualizados!=NULL && $idBalancesActualizados!="")
                {
                    $fechaParametro = "$idBalancesActualizados";
                    $criteriaAux=new CDbCriteria;
                    $criteriaAux->addCondition(
                            array(
                                "EXTRACT(YEAR FROM Fecha)='".date("Y",strtotime($fechaParametro))."'",
                                "EXTRACT(MONTH FROM Fecha)='".date("m",strtotime($fechaParametro))."'",
                                )
                            );
                    $criteriaAux->group = "Fecha";
                    return new CActiveDataProvider($this, array(
                        'criteria'=>$criteriaAux,
                        'sort'=>array(
                            'defaultOrder'=>'Fecha DESC'
                            ),
                        'pagination'=>array(
                            'pageSize'=>31
                            ),
                        ));
                }
                
                if(isset($mes) || isset($cabina))
                {
                    $condition="Id>0";
                    if($mes)
                    {
                        $condition.=" AND Fecha<='".$mes."-31' AND Fecha>='".$mes."-01'";
                    }
                    if($cabina)
                    {
                        $condition.=" AND CABINA_Id=".$cabina;
                    }
                    $pagina=self::model()->count($condition);
                    
                    if($post == 'admin')
                        $pagina=Cabina::model()->count(array(
                        'condition'=>'status=:status AND Id!=:Id AND Id!=:Id2',
                        'params'=>array(
                            ':status'=>1,
                            ':Id'=>18,
                            ':Id2'=>19,
                            ),
                        ));
                    
                    $orden="Fecha DESC, cABINA.Nombre ASC";
                }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array('defaultOrder'=>$orden),
                        'pagination'=>array('pageSize'=>$pagina),
		)); 
                
                
	}
        
        public function disable($post=null,$mes=null,$cabina=null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Id',$this->Id);
		$criteria->compare('SUM(SaldoAp)',$this->SaldoAp,true);
		$criteria->compare('SaldoCierre',$this->SaldoCierre,true);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('CABINA_Id',$this->CABINA_Id);
		$criteria->compare('COMPANIA_Id',$this->COMPANIA_Id);
                $criteria->with =array('cABINA');
                $criteria->addCondition("cABINA.status = 0");
                $criteria->group='Fecha,CABINA_Id';
                
                $pagina=Cabina::model()->count(array(
                        'condition'=>'status=:status AND Id!=:Id AND Id!=:Id2',
                        'params'=>array(
                            ':status'=>0,
                            ':Id'=>18,
                            ':Id2'=>19,
                            ),
                        ));
		$orden="Fecha DESC, cABINA.Nombre ASC";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array('defaultOrder'=>$orden),
                        'pagination'=>array('pageSize'=>$pagina),
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
        
        public static function getSaldoCierre($fecha,$cabina)
	{
            $model = self::model()->findBySql("SELECT SUM(SaldoCierre) as SaldoCierre
                                               FROM saldo_cabina 
                                               WHERE Fecha = '$fecha' AND CABINA_Id = $cabina;");
            if($model->SaldoCierre != NULL)
                return $model->SaldoCierre;
            else
                return '0.00';
	}
        
        public static function getIdFromDate($fecha,$cabina) {
            
            $model = self::model()->find("Fecha = '$fecha' AND CABINA_Id = $cabina");
            return $model->Id;
            
        }
                
        public static function get_Model($ids) 
        {
            $sql = "SELECT s.Id, s.Fecha as Fecha, s.CABINA_Id as CABINA_Id, c.Nombre as Cabina
                    FROM saldo_cabina s
                    INNER JOIN cabina c ON c.id = s.CABINA_Id
                    WHERE s.Id IN(21775) 
                    ORDER BY s.Fecha DESC, c.Nombre ASC;";
            
              return self::model()->findAllBySql($sql); 
        }
}
