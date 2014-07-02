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
        public $TSoles;
        public $TDolares;
        public $MontoD;
        public $MontoS;
        public $MontoDolares;
        public $MontoSoles;
        
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
        
        public $CobrosMov;
        public $Linea147hp;
        public $TarjetaClaro;
        public $CobrosClaro;
        public $RecargaDirectv;
        public $CobrosDirectv;
        public $RecargaNextelCelulares;
        public $TarjetaNextel;
        
        public $OtrosServicios;
        public $OtrosServiciosFullCarga;
        public $Trafico;
        public $RecargaMovistar;
        public $RecargaClaro;
        public $TotalVentas;
        
        public $ServMov;
        public $ServClaro;
        public $ServDirecTv;
        public $ServNextel;
        
        public $SaldoAp;
        public $SaldoCierre;
        public $MontoDeposito;
        
        public $DiferencialBan;
        public $ConciliacionBan;
        public $Paridad;
        
        public $DifMov;
        public $DifClaro;
        public $DifDirecTv;
        public $DifNextel;
        public $DifFullCarga;


        public $DifSoles;
        public $DifDollar;
        
        public $TraficoCapturaDollar;
        
        public $Acumulado;
        public $Sobrante;
        public $SobranteAcum;
        
        public $Ventas;
        
        public $FechaInicioCaptura;
        public $FechaFinCaptura;
        
        public $Vereficar;

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
                        'moneda0' => array(self::BELONGS_TO, 'Currency', 'moneda'),
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
                        'ServMov' => 'Servicios Movistar (S/.)',
                        'ServClaro' => 'Servicios Claro (S/.)',
                        'ServDirecTv' => 'Servicios DirecTv (S/.)',
                        'ServNextel' => 'Servicios Nextel (S/.)',
                        'Trafico' => 'Trafico (S/.)',
                        'OtrosServicios' => 'Otros Servicios (S/.)',
                        'OtrosServiciosFullCarga' => 'Otros Servicios FullCarga (S/.)',
                        'TotalVentas' => 'Total Ventas (S/.)',
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
                        'DifDollar'=>"Diferencial Captura Dollar (USD $)",
                        'Acumulado'=>'Acumulado Dif. Captura (USD $)',
                        'Sobrante'=>'Sobrante (USD $)',
                        'SobranteAcum'=>'Sobrante Acumulado (USD $)',
                        'Ventas'=>'Seleccionar Compañia',
                        'FechaBalance'=>'Fecha del Balance',
                        'FijoLocal'=>'Fijo Local',
                        'DifFullCarga'=>'Diferencial FullCarga',


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
	public function search($post=null,$cabina=null,$mes=null)
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
                
                $criteria->condition = 'TIPOINGRESO_Id = 2';
                
                if($cabina!=NULL)
                    $criteria->addCondition("CABINA_Id=$cabina");
                if($mes!=NULL)
                    $criteria->addCondition("FechaMes='$mes'");

                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchBalance($post=null,$mes=null,$cabina=null)
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
                $criteria->with =array('cABINA');
                $criteria->condition = "TIPOINGRESO_Id!=1";
                $criteria->addCondition("cABINA.status = 1");
                $criteria->group='FechaMes,CABINA_Id';
                
                if($cabina!=NULL)
                    $criteria->addCondition("CABINA_Id=$cabina");
                if($mes!=NULL)
                    $criteria->addCondition("FechaMes<='".$mes."-31' AND FechaMes>='".$mes."-01'");

                $pagina=Cabina::model()->count(array(
                        'condition'=>'status=:status AND Id!=:Id AND Id!=:Id2',
                        'params'=>array(
                            ':status'=>1,
                            ':Id'=>18,
                            ':Id2'=>19,
                            ),
                        ));
                $orden="FechaMes DESC, cABINA.Nombre ASC";
                
                if(isset($mes) || isset($cabina))
                {
                    $condition="Id>0";
                    if($mes)
                    {
                        $condition.=" AND FechaMes<='".$mes."-31' AND FechaMes>='".$mes."-01'";
                    }
                    if($cabina)
                    {
                        $condition.=" AND CABINA_Id=".$cabina;
                    }
                    $pagina=self::model()->count($condition);
                    
                    if($post['vista'] == 'admin')
                        $pagina=NULL;
                    
                    $orden="FechaMes DESC, cABINA.Nombre ASC";
                }
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array('defaultOrder'=>$orden),
                        'pagination'=>array('pageSize'=>$pagina),
		));
	}
        
        public function disable($post=null,$mes=null,$cabina=null)
	{
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
                $criteria->with =array('cABINA');
                $criteria->condition = "TIPOINGRESO_Id!=1";
                $criteria->addCondition("cABINA.status = 0");
                $criteria->group='FechaMes,CABINA_Id';
                
                if($cabina!=NULL)
                    $criteria->addCondition("CABINA_Id=$cabina");
                if($mes!=NULL)
                    $criteria->addCondition("FechaMes<='".$mes."-31' AND FechaMes>='".$mes."-01'");

                $pagina=Cabina::model()->count(array(
                        'condition'=>'status=:status AND Id!=:Id AND Id!=:Id2',
                        'params'=>array(
                            ':status'=>0,
                            ':Id'=>18,
                            ':Id2'=>19,
                            ),
                        ));
                $orden="FechaMes DESC, cABINA.Nombre ASC";
                
                if(isset($mes) || isset($cabina))
                {
                    $condition="Id>0";
                    if($mes)
                    {
                        $condition.=" AND FechaMes<='".$mes."-31' AND FechaMes>='".$mes."-01'";
                    }
                    if($cabina)
                    {
                        $condition.=" AND CABINA_Id=".$cabina;
                    }
                    $pagina=self::model()->count($condition);
                    $orden="FechaMes DESC, cABINA.Nombre ASC";
                }
                
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
	 * @return Detalleingreso the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getLibroVentas($vista,$atributo,$fecha,$cabinaId=NULL,$tipoIngreso=NULL)
	{
            
                if($vista == 'Servicios')
                {
                        $ingreso = self::model()->findBySql("SELECT SUM(IFNULL(d.Monto,0)) as Monto
                                                             FROM detalleingreso as d
                                                             INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                             INNER JOIN users as u ON u.id = d.USERS_Id
                                                             WHERE d.FechaMes = '$fecha' 
                                                             AND d.CABINA_Id = $cabinaId 
                                                             AND t.Nombre = '$atributo';");
                        if($ingreso->Monto == NULL)
                            return '0.00';
                        else
                            return $ingreso->Monto;

                    
                }elseif($vista == 'Llamadas')
                {
                    if($atributo != 'TotalLlamadas'){
                        $ingreso = self::model()->findBySql("SELECT SUM(IFNULL(d.Monto,0)) as Monto
                                                             FROM detalleingreso as d
                                                             INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                             INNER JOIN users as u ON u.id = d.USERS_Id
                                                             WHERE d.FechaMes = '$fecha' 
                                                             AND d.CABINA_Id = $cabinaId 
                                                             AND t.Nombre = '$atributo';");
                        if($ingreso->Monto == NULL)
                            return '0.00';
                        else
                            return $ingreso->Monto;
                    }else{
                        $ingreso = self::model()->findBySql("SELECT SUM(IFNULL(d.Monto,0)) as Monto
                                                             FROM detalleingreso as d
                                                             INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                             INNER JOIN users as u ON u.id = d.USERS_Id
                                                             WHERE d.FechaMes = '$fecha' 
                                                             AND d.CABINA_Id = $cabinaId 
                                                             AND t.COMPANIA_Id = 5 AND t.Clase = 1;");
                        if($ingreso->Monto == NULL)
                            return '0.00';
                        else
                            return $ingreso->Monto;
                    }
                    
                }
                
                //LIBRO DE VENTAS
                elseif($vista == 'LibroVentas')
                {
                    if($atributo == 'servicio'){
                        $ingreso = self::model()->findBySql("SELECT d.Monto 
                                                             FROM detalleingreso as d
                                                             INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                             INNER JOIN users as u ON u.id = d.USERS_Id
                                                             WHERE d.FechaMes = '$fecha' 
                                                             AND d.CABINA_Id = $cabinaId 
                                                             AND t.COMPANIA_Id = 6 AND u.tipo = 1;");
                        if($ingreso == NULL)
                            return '0.00';
                        else
                            return $ingreso->Monto;
                    }
                    elseif($atributo == 'trafico'){
                        $trafico = self::model()->findBySql("SELECT SUM(d.Monto) as Trafico 
                                                             FROM detalleingreso as d
                                                             INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                             WHERE d.FechaMes = '$fecha' 
                                                             AND d.CABINA_Id = $cabinaId AND t.COMPANIA_Id = 5 AND t.Clase = 1;");
                        if ($trafico == NULL) {
                            return '0.00';
                        } else {
                            if ($trafico->Trafico == NULL)
                                return '0.00';
                            else
                                return $trafico->Trafico;
                        }
                    }
                    elseif($atributo == 'traficoER'){
                        $trafico = self::model()->findBySql("SELECT SUM(d.Monto) as Trafico 
                                                             FROM detalleingreso as d
                                                             INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                             INNER JOIN users as u ON u.id = d.USERS_Id
                                                             WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                                                             AND d.CABINA_Id = $cabinaId AND t.COMPANIA_Id = 5 AND t.Clase = 1;");
                        if ($trafico == NULL) {
                            return '0.00';
                        } else {
                            if ($trafico->Trafico == NULL)
                                return '0.00';
                            else
                                return $trafico->Trafico;
                        }
                    }
                    elseif($atributo == 'ServMov'){
                        $ServMov = self::model()->findBySql("SELECT SUM(d.Monto) as ServMov 
                                                                FROM detalleingreso as d
                                                                INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                                INNER JOIN users as u ON u.id = d.USERS_Id
                                                                WHERE d.FechaMes = '$fecha' 
                                                                AND d.CABINA_Id = $cabinaId 
                                                                AND t.COMPANIA_Id = 1 AND u.tipo = 1;");
                        if($ServMov->ServMov == NULL)
                            return '0.00';
                        else
                            return $ServMov->ServMov;
                    }
                    elseif($atributo == 'ServClaro'){
                        $ServClaro = self::model()->findBySql("SELECT SUM(d.Monto) as ServClaro 
                                                                FROM detalleingreso as d
                                                                INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                                INNER JOIN users as u ON u.id = d.USERS_Id
                                                                WHERE d.FechaMes = '$fecha' 
                                                                AND d.CABINA_Id = $cabinaId 
                                                                AND t.COMPANIA_Id = 2 AND u.tipo = 1;");
                        if($ServClaro->ServClaro == NULL)
                            return '0.00';
                        else
                            return $ServClaro->ServClaro;
                    }
                    elseif($atributo == 'ServNextel'){
                        $ServNextel = self::model()->findBySql("SELECT SUM(d.Monto) as ServNextel 
                                                                FROM detalleingreso as d
                                                                INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                                INNER JOIN users as u ON u.id = d.USERS_Id
                                                                WHERE d.FechaMes = '$fecha' 
                                                                AND d.CABINA_Id = $cabinaId 
                                                                AND t.COMPANIA_Id = 3 AND u.tipo = 1;");
                        if($ServNextel->ServNextel == NULL)
                            return '0.00';
                        else
                            return $ServNextel->ServNextel;
                    }
                    elseif($atributo == 'ServDirecTv'){
                        $ServDirecTv = self::model()->findBySql("SELECT SUM(d.Monto) as ServDirecTv 
                                                                FROM detalleingreso as d
                                                                INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                                INNER JOIN users as u ON u.id = d.USERS_Id
                                                                WHERE d.FechaMes = '$fecha' 
                                                                AND d.CABINA_Id = $cabinaId 
                                                                AND t.COMPANIA_Id = 4 AND u.tipo = 1;");
                        if($ServDirecTv->ServDirecTv == NULL)
                            return '0.00';
                        else
                            return $ServDirecTv->ServDirecTv;
                    }
                    elseif($atributo == 'TotalVentas'){
                        
                        if($cabinaId != NULL){
                             $sql = "SELECT SUM(d.Monto) as TotalVentas 
                                                                FROM detalleingreso as d
                                                                INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                                INNER JOIN users as u ON u.id = d.USERS_Id
                                                                WHERE d.FechaMes = '$fecha' 
                                                                AND d.CABINA_Id = $cabinaId 
                                                                AND t.COMPANIA_Id > 0 AND t.COMPANIA_Id != 12 AND u.tipo = 1;";
                        }elseif($cabinaId == NULL){
                            $sql = "SELECT SUM(d.Monto) as TotalVentas 
                                                                FROM detalleingreso as d
                                                                INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                                INNER JOIN users as u ON u.id = d.USERS_Id
                                                                WHERE d.FechaMes = '$fecha' 
                                                                AND t.COMPANIA_Id > 0 AND t.COMPANIA_Id != 12 AND u.tipo = 1;";
                        }
                        
                        //$TotalVentas = 0;
                        $TotalVentas = self::model()->findBySql($sql);
                        if($TotalVentas->TotalVentas == NULL){
                            return '0.00';
                        }else{
                            return $TotalVentas->TotalVentas;
                        }  
                        
                    }
                    elseif($atributo == 'OtrosServiciosFullCarga'){
                        $TotalVentas = 0;
                        $TotalVentas = self::model()->findBySql("SELECT SUM(d.Monto) as TotalVentas 
                                                                FROM detalleingreso as d
                                                                INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                                INNER JOIN users as u ON u.id = d.USERS_Id
                                                                WHERE d.FechaMes = '$fecha' 
                                                                AND d.CABINA_Id = $cabinaId 
                                                                AND t.COMPANIA_Id > 6 AND t.COMPANIA_Id != 12 AND u.tipo = 1;");
                        if($TotalVentas->TotalVentas == NULL)
                            return '0.00';
                        else
                            return $TotalVentas->TotalVentas;
                    }
                }
	}
        
        public static function montoGasto($moneda)
        {     
            $mon;
            if($moneda == null){
                $mon = '00.00';
            }else{
                $mon = $moneda;
            }

            return $mon;
        }
        
        public static function Recargas($fecha,$cabina,$compania,$acumulado=NULL)
        {   
            
            if($compania == 1){
                $atributo = 'DifMov';
            }elseif($compania == 2){
                $atributo = 'DifClaro';
            }elseif($compania == 4){
                $atributo = 'DifDirecTv';
            }elseif($compania == 3){
                $atributo = 'DifNextel';
            }elseif($compania == 'FullCarga'){
                $atributo = 'DifFullCarga';
            }

            if($acumulado == NULL){
                $ServDirecTv = self::model()->findBySql("SELECT SUM(IFNULL(d.Monto,0)) as $atributo 
                                                        FROM detalleingreso as d
                                                        INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                        INNER JOIN users as u ON u.id = d.USERS_Id
                                                        WHERE d.FechaMes = '$fecha' 
                                                        AND d.CABINA_Id = $cabina 
                                                        AND t.COMPANIA_Id = $compania AND u.tipo = 1;");
                
            }elseif($acumulado != NULL && $acumulado!='FullCarga'){
                $primero_mes = date('Y-m', strtotime($fecha)).'-01';
                $ServDirecTv = self::model()->findBySql("SELECT SUM(IFNULL(d.Monto,0)) as $atributo 
                                                        FROM detalleingreso as d
                                                        INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                        INNER JOIN users as u ON u.id = d.USERS_Id
                                                        WHERE d.FechaMes >= '$primero_mes'
                                                        AND d.FechaMes <= '$fecha' 
                                                        AND d.CABINA_Id = $cabina 
                                                        AND t.COMPANIA_Id = $compania AND u.tipo = 1;");
                
            }elseif($acumulado != NULL && $acumulado=='FullCarga'){
                $primero_mes = date('Y-m', strtotime($fecha)).'-01';
                $ServDirecTv = self::model()->findBySql("SELECT SUM(IFNULL(d.Monto,0)) as $atributo 
                                                        FROM detalleingreso as d
                                                        INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                        INNER JOIN users as u ON u.id = d.USERS_Id
                                                        WHERE d.FechaMes = '$fecha' 
                                                        AND d.CABINA_Id = $cabina 
                                                        AND t.COMPANIA_Id > 0 AND t.COMPANIA_Id < 5 AND u.tipo = 1;");
            }
            
            if($ServDirecTv->$atributo == NULL)
                return '0.00';
            else
                return $ServDirecTv->$atributo;
        }
        
        public static function VentasRecargas($fecha,$cabina,$compania=NULL,$acumulado=NULL)
        {   
            
            if($compania == 1){
                $atributo = 'DifMov';
            }elseif($compania == 2){
                $atributo = 'DifClaro';
            }elseif($compania == 4){
                $atributo = 'DifDirecTv';
            }elseif($compania == 3){
                $atributo = 'DifNextel';
            }elseif($compania == 'FullCarga'){
                $atributo = 'DifFullCarga';
            }
            
            if($acumulado == NULL){
                $ServDirecTv = self::model()->findBySql("SELECT SUM(IFNULL(d.Monto,0)) as $atributo 
                                                        FROM detalleingreso as d
                                                        INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                        INNER JOIN users as u ON u.id = d.USERS_Id
                                                        WHERE d.FechaMes = '$fecha' 
                                                        AND d.CABINA_Id = $cabina 
                                                        AND t.COMPANIA_Id = $compania AND u.tipo = 4;");
                
            }elseif($acumulado != NULL && $acumulado!='FullCarga'){
                $primero_mes = date('Y-m', strtotime($fecha)).'-01';
                $ServDirecTv = self::model()->findBySql("SELECT SUM(IFNULL(d.Monto,0)) as $atributo 
                                                        FROM detalleingreso as d
                                                        INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                        INNER JOIN users as u ON u.id = d.USERS_Id
                                                        WHERE d.FechaMes >= '$primero_mes'
                                                        AND d.FechaMes <= '$fecha' 
                                                        AND d.CABINA_Id = $cabina 
                                                        AND t.COMPANIA_Id = $compania AND u.tipo = 4;");
                
            }elseif($acumulado != NULL && $acumulado=='FullCarga'){
                $primero_mes = date('Y-m', strtotime($fecha)).'-01';
                $ServDirecTv = self::model()->findBySql("SELECT SUM(IFNULL(d.Monto,0)) as $atributo 
                                                        FROM detalleingreso as d
                                                        INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                        INNER JOIN users as u ON u.id = d.USERS_Id
                                                        WHERE d.FechaMes = '$fecha' 
                                                        AND d.CABINA_Id = $cabina 
                                                        AND t.COMPANIA_Id > 0 AND t.COMPANIA_Id < 5 AND u.tipo = 4;");
            } 
                
            if($ServDirecTv->$atributo == NULL)
                return '0.00';
            else
                return $ServDirecTv->$atributo;
        }
        
        public static function TraficoCapturaDollar($fecha,$cabina,$acumulado=NULL)
        {   
            $primero_mes = date('Y-m', strtotime($fecha)).'-01';
            
            if($acumulado == NULL){
                $ServDirecTv = self::model()->findBySql("SELECT SUM(IFNULL(d.Monto,0)) as TraficoCapturaDollar 
                                                        FROM detalleingreso as d
                                                        INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                        INNER JOIN users as u ON u.id = d.USERS_Id
                                                        WHERE d.FechaMes = '$fecha' 
                                                        AND d.CABINA_Id = $cabina 
                                                        AND t.COMPANIA_Id = 5 AND t.Clase = 2;");
            }else{
                $ServDirecTv = self::model()->findBySql("SELECT SUM(IFNULL(d.Monto,0)) as TraficoCapturaDollar 
                                                        FROM detalleingreso as d
                                                        INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                        INNER JOIN users as u ON u.id = d.USERS_Id
                                                        WHERE d.FechaMes >= '$primero_mes' 
                                                        AND d.FechaMes <= '$fecha'
                                                        AND d.CABINA_Id = $cabina 
                                                        AND t.COMPANIA_Id = 5 AND u.tipo = 4;");
            }
            
            if($ServDirecTv->TraficoCapturaDollar == NULL)
                return '0.00';
            else
                return $ServDirecTv->TraficoCapturaDollar;
        }
        
        public static function getDiferencial($fecha,$cabina,$moneda=NULL) {
            $paridad = Paridad::getParidad($fecha);
            $ventas = Detalleingreso::getLibroVentas("LibroVentas","trafico", $fecha,$cabina);
            $traficoCaptura = Detalleingreso::TraficoCapturaDollar($fecha,$cabina);
            if($moneda == NULL)
                return round(($ventas)-($traficoCaptura*$paridad),2);
            else
                return round(($ventas-$traficoCaptura*$paridad)/$paridad,2);
            
        }
        
        public static function getDifFullCarga($fecha,$cabina) {
            $dif = 0;
            $dif = self::VentasRecargas($fecha,$cabina, 'FullCarga','FullCarga')-self::Recargas($fecha,$cabina, 'FullCarga','FullCarga');
            return $dif;
        }
        
        public static function getSobrante($fecha,$cabina)
        {     
            $sum = 0;
            $paridad = Paridad::getParidad($fecha);
            $difBanco = (Deposito::getMontoBanco($fecha,$cabina)-self::getLibroVentas("LibroVentas","TotalVentas", $fecha,$cabina));
            $difMov = self::VentasRecargas($fecha,$cabina, 1)-self::Recargas($fecha,$cabina, 1);
            $difClaro = self::VentasRecargas($fecha,$cabina, 2)-self::Recargas($fecha,$cabina, 2);
            $difDirecTv = self::VentasRecargas($fecha,$cabina, 4)-self::Recargas($fecha,$cabina, 4);
            $difNextel = self::VentasRecargas($fecha,$cabina, 3)-self::Recargas($fecha,$cabina, 3);
            $difCaptura = self::getDiferencial($fecha,$cabina);
            
            $sum = ($difBanco + $difMov + $difClaro + $difDirecTv + $difNextel + $difCaptura)/$paridad;    
            
            return round($sum,2);
        }
        
        public static function getAcumulado($fecha,$cabina) {
            
            return round((self::Acumulado($fecha,$cabina,false)-Detalleingreso::TraficoCapturaDollar($fecha,$cabina,'Completo')*Paridad::getParidad($fecha))/Paridad::getParidad($fecha),2);
            
        }
        
        public static function Acumulado($fecha,$cabina,$total)
        {
            $sum = 0;
            $primero_mes = date('Y-m', strtotime($fecha)).'-01';
            if($total == false)

                $sum = self::model()->findBySql("SELECT SUM(d.Monto) as DifDollar 
                                                 FROM detalleingreso as d
                                                 INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                 INNER JOIN users as u ON u.id = d.USERS_Id
                                                 WHERE d.FechaMes >= '$primero_mes' 
                                                 AND d.FechaMes <= '$fecha'
                                                 AND d.CABINA_Id = $cabina 
                                                 AND t.COMPANIA_Id = 5 
                                                 AND u.tipo = 1;");
            else
                $sum = self::model()->findBySql("SELECT SUM((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)-IFNULL(b.TraficoCapturaDollar,0)*p.Valor)/p.Valor) as DifDollar 
                                                FROM balance as b 
                                                INNER JOIN paridad as p ON p.id = b.PARIDAD_Id 
                                                INNER JOIN cabina as c ON c.Id = b.CABINA_Id 
                                                WHERE (b.Fecha >= '$primero_mes' AND b.Fecha <= '$fecha') AND b.CABINA_Id IN(SELECT Id FROM cabina WHERE status=1 AND Id != 18 AND Id != 19 AND Id != 20);");


            return round($sum->DifDollar,2);
        }
        
        public static function getSobranteAcumulado($fecha,$cabina)
        {     
            $sum = 0;
            //$sum = self::model()->findBySql("SELECT sobranteActual('$fecha',$cabina) as SobranteAcum;")->SobranteAcum;
            $paridad = Paridad::getParidad($fecha);
            $primero_mes = date('Y-m', strtotime($fecha)).'-01';
            
            $montoDep = Deposito::model()->findBySql("SELECT SUM(IFNULL(MontoBanco,0)) as MontoBanco 
                                                    FROM deposito
                                                    WHERE FechaCorrespondiente >= '$primero_mes' 
                                                    AND FechaCorrespondiente <= '$fecha' 
                                                    AND CABINA_Id = $cabina;");
            
            $TotalVentas = self::model()->findBySql("SELECT SUM(IFNULL(d.Monto,0)) as TotalVentas 
                                                                FROM detalleingreso as d
                                                                INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                                INNER JOIN users as u ON u.id = d.USERS_Id
                                                                WHERE d.FechaMes >= '$primero_mes'
                                                                AND d.FechaMes <= '$fecha'    
                                                                AND d.CABINA_Id = $cabina 
                                                                AND t.COMPANIA_Id > 0 AND u.tipo = 1;");
            
            $trafico = self::model()->findBySql("SELECT SUM(IFNULL(d.Monto,0)) as Trafico 
                                                             FROM detalleingreso as d
                                                             INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                             INNER JOIN users as u ON u.id = d.USERS_Id
                                                             WHERE d.FechaMes >= '$primero_mes'
                                                             AND d.FechaMes <= '$fecha' 
                                                             AND d.CABINA_Id = $cabina AND t.COMPANIA_Id = 5 AND u.tipo = 1;");
            
            $traficoCaptura = Detalleingreso::TraficoCapturaDollar($fecha,$cabina,'Complete');
            
            
            
            $difBanco = $montoDep->MontoBanco - $TotalVentas->TotalVentas;
            $difMov = Detalleingreso::VentasRecargas($fecha,$cabina, 1,'Completo')-Detalleingreso::Recargas($fecha,$cabina, 1,'Completo');
            $difClaro = Detalleingreso::VentasRecargas($fecha,$cabina, 2,'Completo')-Detalleingreso::Recargas($fecha,$cabina, 2,'Completo');
            $difDirecTv = Detalleingreso::VentasRecargas($fecha,$cabina, 4,'Completo')-Detalleingreso::Recargas($fecha,$cabina, 4,'Completo');
            $difNextel = Detalleingreso::VentasRecargas($fecha,$cabina, 3,'Completo')-Detalleingreso::Recargas($fecha,$cabina, 3,'Completo');
            $difCaptura = $trafico->Trafico-$traficoCaptura*$paridad;
            
            $sum = ($difBanco + $difMov + $difClaro + $difDirecTv + $difNextel + $difCaptura)/$paridad;    
            
            return round($sum,2);
        }
        
        public static function changeName($name)
        {
            $nameFormate = Array(
                
                //Llamadas
                'FijoLocal'=>'Fijo Local (S/.)',
                'FijoProvincia'=>'Fijo Provincia (S/.)',
                'FijoLima'=>'Fijo Lima (S/.)',
                'Celular'=>'Celular (S/.)',
                'Rural'=>'Rural (S/.)',
                'LDI'=>'LDI (S/.)',
                
                'Otros'=>'Otros Servicios (S/.)',
                
                //Movistar
               'RecargaCelularMov'=>'Recarga Celular Movistar (S/.)',
               'RecargaFonoYaMov'=>'Recarga Fono Ya Movistar (S/.)',
               'RecargasVentasMov'=>'Recargas Ventas Movistar (S/.)',
               'CobrosMov'=>'Cobros Movistar (S/.)',
               'Linea147-hp'=>'Linea 147-hp (S/.)',

                //Claro
               'RecargaCelularClaro'=>'Recarga Celular Claro (S/.)',
               'RecargaFonoClaro'=>'Recarga Fono Claro (S/.)',
               'RecargasVentasClaro'=>'Recargas Ventas Claro (S/.)',
               'TarjetaClaro'=>'Tarjeta Claro (S/.)',
               'CobrosClaro'=>'Cobros Claro (S/.)',
                
                //Nextel
               'RecargaNextelCelulares'=>'Recarga Nextel Celulares (S/.)',
               'TarjetaNextel'=>'Tarjeta Nextel (S/.)',
                
                //DirecTv
               'RecargaDirectv'=>'Recarga Directv (S/.)',
               'CobrosDirectv'=>'Cobros Directv (S/.)',
                
                //IDT
               'PeruGlobal'=>'Peru Global (S/.)',
               'NumeroUNO'=>'Numero UNO (S/.)',
                
                //Convergia
               'HablaSympatico'=>'Habla Sympatico (S/.)',
               'LaRendidora'=>'La Rendidora (S/.)',
                
                //Sedapal
               'ServicioAgua'=>'Servicio de Agua (S/.)',
                
                //Pago Efecto
               'PeriodicoElComercio'=>'Periodico El Comercio (S/.)',
                
                //Juego
               'Juega8'=>'Juega8 (S/.)',

                
            );
             
            return $nameFormate[$name];
        }
        
        
        public static function deleteVentasFullCarga($arrayFecha,$arrayCabina,$arrayTipoIngreso) {
            
            $fechaIngreso = NULL;
            $cabinas = Array();
            $tipoIngresos = Array();
            $compania = NULL;
            
            $fechaIngreso = array_keys(array_count_values(array_unique($arrayFecha)));
            $cabinas = array_keys(array_count_values(array_unique($arrayCabina)));
            $tipoIngresos = array_keys(array_count_values(array_unique($arrayTipoIngreso)));
            
            for($h=0;$h<count($fechaIngreso);$h++) {
                
                for($i=0;$i<count($cabinas);$i++) {

                    for($j=0;$j<count($tipoIngresos);$j++) {
                        
                        $compania = TipoIngresos::model()->findBySql("SELECT COMPANIA_Id FROM tipo_ingresos WHERE Id = $tipoIngresos[$j];");
                        $modelIngreso = Detalleingreso::model()->findBySql("SELECT d.Id as Id 
                                                                            FROM detalleingreso as d
                                                                            INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                                            INNER JOIN users as u ON u.id = d.USERS_Id
                                                                            WHERE d.FechaMes = '$fechaIngreso[$h]'
                                                                            AND d.CABINA_Id = $cabinas[$i]
                                                                            AND t.COMPANIA_Id = $compania->COMPANIA_Id
                                                                            AND t.Clase = 2
                                                                            AND u.tipo = 4;");
                        
                        if($modelIngreso != NULL){
                            Detalleingreso::model()->deleteByPk($modelIngreso->Id);
                        }
                        
                    }
                    
                }
            }    
            
        }
        
        public static function verificarDifFullCarga($arrayFecha,$arrayCabina,$arrayTipoIngreso)
        {
            $ventasOperador = 0;
            $ventasEtelix = 0;
            $fechaIngreso = NULL;
            $cabinas = Array();
            $tipoIngresos = Array();
            $compania = NULL;
            
            $fechaIngreso = array_keys(array_count_values(array_unique($arrayFecha)));
            $cabinas = array_keys(array_count_values(array_unique($arrayCabina)));
            $tipoIngresos = array_keys(array_count_values(array_unique($arrayTipoIngreso)));
            
            for($h=0;$h<count($fechaIngreso);$h++) {
                
                for($i=0;$i<count($cabinas);$i++) {

                    for($j=0;$j<count($tipoIngresos);$j++) {

                        $compania = TipoIngresos::model()->findBySql("SELECT COMPANIA_Id FROM tipo_ingresos WHERE Id = $tipoIngresos[$j];");

                        $ventasOperador = self::model()->findBySql("SELECT SUM(d.Monto) as DifDollar 
                                                                    FROM detalleingreso as d
                                                                    INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                                    INNER JOIN users as u ON u.id = d.USERS_Id
                                                                    WHERE d.FechaMes = '$fechaIngreso[$h]'
                                                                    AND d.CABINA_Id = $cabinas[$i] 
                                                                    AND t.COMPANIA_Id = $compania->COMPANIA_Id    
                                                                    AND u.tipo = 1;")->DifDollar;

                        $ventasEtelix = self::model()->findBySql("SELECT SUM(d.Monto) as DifDollar 
                                                                  FROM detalleingreso as d
                                                                  INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                                  INNER JOIN users as u ON u.id = d.USERS_Id
                                                                  WHERE d.FechaMes = '$fechaIngreso[$h]'
                                                                  AND d.CABINA_Id = $cabinas[$i] 
                                                                  AND t.COMPANIA_Id = $compania->COMPANIA_Id
                                                                  AND t.Clase = 1    
                                                                  AND u.tipo = 4;")->DifDollar;

                        if($ventasOperador != NULL && $ventasEtelix != NULL){

                            $modelCicloIngreso = CicloIngresoModelo::model()->find("Fecha = '$fechaIngreso[$h]' AND CABINA_Id = $cabinas[$i]");
                            if($modelCicloIngreso != NULL){

                                if($compania->COMPANIA_Id == 1){
                                    $modelCicloIngreso->DiferencialMovistar = round(($ventasEtelix-$ventasOperador),2);
                                }elseif($compania->COMPANIA_Id == 2){
                                    $modelCicloIngreso->DiferencialClaro = round(($ventasEtelix-$ventasOperador),2);
                                }elseif($compania->COMPANIA_Id == 3){
                                    $modelCicloIngreso->DiferencialNextel= round(($ventasEtelix-$ventasOperador),2);
                                }elseif($compania->COMPANIA_Id == 4){
                                    $modelCicloIngreso->DiferencialDirectv = round(($ventasEtelix-$ventasOperador),2);
                                }

                                $modelCicloIngreso->save();

                            }elseif($modelCicloIngreso == NULL){
                                
                                $modelCI = new CicloIngresoModelo;
                                $modelCI->Fecha = $fechaIngreso[$h];
                                $modelCI->CABINA_Id = $cabinas[$i];   

                                if($compania->COMPANIA_Id == 1){
                                    $modelCI->DiferencialMovistar = round(($ventasEtelix-$ventasOperador),2);
                                }elseif($compania->COMPANIA_Id == 2){
                                    $modelCI->DiferencialClaro = round(($ventasEtelix-$ventasOperador),2);
                                }elseif($compania->COMPANIA_Id == 3){
                                    $modelCI->DiferencialNextel= round(($ventasEtelix-$ventasOperador),2);
                                }elseif($compania->COMPANIA_Id == 4){
                                    $modelCI->DiferencialDirectv = round(($ventasEtelix-$ventasOperador),2);
                                }

                                $modelCI->save();
                            }

                        }

                    }
                }
                    
            }

        }
        
        public static function getDataFullCarga($fecha,$cabina,$compania){
        
            if($compania == 'SubArriendos'){

                $sql="SELECT SUM(d.Monto) as Monto
                      FROM detalleingreso as d
                      INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                      INNER JOIN users as u ON u.id = d.USERS_Id
                      WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                      AND d.CABINA_Id = $cabina 
                      AND t.Id = 1 AND t.Clase = 1;";

            }elseif($compania != 'SubArriendos'){

                $sql="SELECT SUM(d.Monto) as Monto
                      FROM detalleingreso as d
                      INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                      INNER JOIN users as u ON u.id = d.USERS_Id
                      WHERE d.FechaMes >= '$fecha-01' AND d.FechaMes <= '$fecha-31' 
                      AND d.CABINA_Id = $cabina 
                      AND t.COMPANIA_Id = $compania AND t.Clase = 1;";

            }


            $servicios = self::model()->findBySql($sql);

            if($servicios == NULL){

                return '0.00';

            }else{

                if($servicios->Monto == NULL){
                    return '0.00';
                }else{
                    return  $servicios->Monto;
                }

            }

        }
        
        public static function getCostoLlamada($fecha)
        {

            $arrayCarriers = Array();
            $arrayCa = Array();
            $cabinaNombre = Cabina::getNombreCabina2($cabina);


            if($cabinaNombre != 'ETELIX - PERU'){
                $cabinasSori = Carrier::model()->findAllBySql("SELECT id FROM carrier WHERE name LIKE '%$cabinaNombre%';");
            }else{
                $cabinasSori = Carrier::model()->findAllBySql("SELECT id FROM carrier WHERE name LIKE '%ETELIX.COM%';");
            }

            foreach ($cabinasSori as $key2 => $value) {
                $arrayCa[0][$key2] = $value->id;
                $arrayCarriers[0] = implode(',', $arrayCa[0]);
            }

            $model = BalanceSori::model()->findBySql("SELECT SUM(b.cost) as cost
                                                      FROM balance as b
                                                      WHERE b.date_balance >= '$fecha-01' 
                                                      AND b.date_balance <= '$fecha-31'
                                                      AND b.id_carrier_customer IN($arrayCarriers[0])
                                                      AND id_destination is NULL;");

            if($model != NULL){

                if($model->cost != NULL){
                    return round($model->cost,2);
                }else{
                    return 0.00;
                }    

            }else{
                return 0.00;
            }


        }
        
}
