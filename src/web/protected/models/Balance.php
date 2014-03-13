<?php

/**
 * This is the model class for table "balance".
 *
 * The followings are the available columns in table 'balance':
 * @property integer $Id
 * @property string $Fecha
 * @property string $SaldoApMov
 * @property string $SaldoApClaro
 * @property string $SaldoCierreMov
 * @property string $SaldoCierreCarol
 * @property string $FijoLocal
 * @property string $FijoProvincia
 * @property string $FijoLima
 * @property string $Rural
 * @property string $Celular
 * @property string $LDIcon
 * @property string $RecargaCelularMov
 * @property string $RecargaFonoYaMov
 * @property string $RecargaCelularClaro
 * @property string $RecargaFonoClaro
 * @property string $OtrosServicios
 * @property string $MontoDeposito
 * @property string $NumRefDeposito
 * @property string $MontoBanco
 * @property string $ConciliacionBancaria
 * @property string $DiferencialBancario
 * @property string $FechaIngresoLlamadas
 * @property string $FechaIngresoDeposito
 * @property string $TraficoCapturaDollar
 * @property string $RecargaVentasMov
 * @property string $RecargaVentasClaro
 * @property string $FechaDep
 * @property string $HoraDep
 * @property string $Depositante
 * @property string $TiempoCierre
 * @property integer $CABINA_Id
 * @property integer $PARIDAD_Id
 * @property integer $Acumulado
 * @property integer $MinutosCaptura
 * @property integer $SobranteAcum
 * @property integer $CUENTA_Id
 * jhfgjyh
 * The followings are the available model relations:
 * @property Cabina $CABINA
 */
class Balance extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Balance the static model class
	 */
    public $cabina;
    public $tagTodasLasCabina='Todas';
    public $RecargaMovistar; 
    public $RecargaClaro; 
    public $Paridad; 
    public $CaptSoles; 
    public $DifSoles; 
    public $DifDollar; 
    public $Trafico; 
    public $Total; 
    public $TotalVentas; 
    public $DifMov; 
    public $DifClaro; 
    public $ConciliacionBancariaCI; 
    public $DifBancoCI;
    public $MontoDepositoOp;
    public $Sobrante;

    /**
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
     * @access public
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'balance';
	}

	/**
     * @access public
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//Campos requeridos a la hora de declarar un deposito
			array('Fecha, FechaDep, HoraDep, MontoDeposito, NumRefDeposito', 'required',/*Creacion de escenario*/ 'on'=>'declararDeposito', 'message'=>'{attribute} no puede estar vacio'),
			//Campos requeridos al declarar saldo de apertura
			array('Fecha, SaldoApMov, SaldoApClaro', 'required', 'on'=>'declararApertura'),
			//Campos requeridos al momento de declarar las ventas
			array('Fecha, FijoLocal, FijoProvincia, FijoLima, Rural, Celular, LDI, RecargaCelularMov, RecargaFonoYaMov, RecargaCelularClaro, RecargaFonoClaro, OtrosServicios', 'required', 'on'=>'declararVentas', 'message'=>'{attribute} no puede estar vacio, en caso de no haber ventas coloque 0'),
			//Campos requeridos al momento de declarar las ventas Captura
			array('Fecha, CABINA_Id', 'required', 'on'=>'declararCaptura'),
                        //Campos requeridos al momento de declarar las ventas en Brightstar
			array('Fecha, CABINA_Id', 'required', 'on'=>'declararBrightstar'),
			//Son campos numericos y pueden incluir otro valor diferente de numeros
			array('CABINA_Id,PARIDAD_Id, SaldoApMov, SaldoApClaro, SaldoCierreMov, SaldoCierreClaro, FijoLocal, FijoProvincia, FijoLima, Rural, Celular, LDI, RecargaCelularMov, RecargaFonoYaMov, RecargaCelularClaro, RecargaFonoClaro, OtrosServicios, MontoDeposito, MontoBanco, ConciliacionBancaria,DiferencialBancario, TraficoCapturaDollar, RecargaVentasMov, RecargaVentasClaro, TiempoCierre', 'numerical', 'integerOnly'=>false),
			//la longitud maxima es de 30
			array('SaldoApMov, SaldoApClaro, SaldoCierreMov, SaldoCierreClaro, FijoLocal, FijoProvincia, FijoLima, Rural, Celular, LDI, RecargaCelularMov, RecargaFonoYaMov, RecargaCelularClaro, RecargaFonoClaro, OtrosServicios, MontoDeposito, MontoBanco, ConciliacionBancaria,DiferencialBancario, TraficoCapturaDollar, RecargaVentasMov, RecargaVentasClaro, Depositante, TiempoCierre', 'length', 'max'=>30),
			//la longitud maxima es de 45
			array('NumRefDeposito', 'length', 'max'=>45),
			array('FechaIngresoLlamadas, FechaIngresoDeposito, FechaDep, HoraDep', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Fecha, SaldoApMov, SaldoApClaro, SaldoCierreMov, SaldoCierreClaro, FijoLocal, FijoProvincia, FijoLima, Rural, Celular, LDI, RecargaCelularMov, RecargaFonoYaMov, RecargaCelularClaro, RecargaFonoClaro, OtrosServicios, MontoDeposito, NumRefDeposito, MontoBanco, ConciliacionBancaria,DiferencialBancario, FechaIngresoLlamadas, FechaIngresoDeposito,TraficoCapturaDollar, RecargaVentasMov, RecargaVentasClaro, FechaDep, HoraDep, Depositante, TiempoCierre, CABINA_Id, PARIDAD_Id', 'safe', 'on'=>'search'),
		);
	}

	/**
     * @access public
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'cABINA'=>array(self::BELONGS_TO,'Cabina','CABINA_Id'),
			'pARIDAD'=>array(self::BELONGS_TO,'Paridad','PARIDAD_Id'),
			'cUENTA'=>array(self::BELONGS_TO,'Cuenta','CUENTA_Id'),
		);
	}

	/**
     * @access public
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
//		if(Yii::app()->getModule('user')->user()->CABINA_Id != '17') 
                    return array(
			'Id' => 'ID',
			'Fecha' => 'Fecha del Balance',
			'SaldoApMov' => 'Saldo Apertura Movistar (S/.)',
			'SaldoApClaro' => 'Saldo Apertura Claro (S/.)',
			'SaldoCierreMov' => 'Saldo Cierre Movistar (S/.)',
			'SaldoCierreClaro' => 'Saldo Cierre Claro (S/.)',
			'FijoLocal' => 'Fijo Local (S/.)',
			'FijoProvincia' => 'Fijo Provincia (S/.)',
			'FijoLima' => 'Fijo Lima (S/.)',
			'Rural' => 'Rural (S/.)',
			'Celular' => 'Celular (S/.)',
			'LDI' => 'LDI (S/.)',
                        'Ldi4 (S/.)',
			'RecargaCelularMov' => 'Recarga Celular Movistar (S/.)',
			'RecargaFonoYaMov' => 'Recarga Fono Ya Movistar (S/.)',
			'RecargaCelularClaro' => 'Recarga Celular Claro (S/.)',
			'RecargaFonoClaro' => 'Recarga Fono Claro (S/.)',
			'OtrosServicios' => 'Otros Servicios (S/.)',
			'MontoDeposito' => "Monto Deposito (S/.) 'B'",
			'MontoDepositoOp' => "Monto Deposito (S/.)",
			'NumRefDeposito' => 'Numero de Ref Deposito ',
			'MontoBanco' => "Monto Banco (S/.) 'C'",
			'ConciliacionBancaria' => "Conciliaci&oacute;n Bancaria (S/.) 'C-B'",
			'ConciliacionBancariaCI' => "Conciliaci&oacute;n Bancaria (S/.)",
			'FechaIngresoLlamadas' => 'Fecha Ingreso Llamadas',
			'FechaIngresoDeposito' => 'Fecha Ingreso Deposito',
			'TraficoCapturaDollar' => 'Trafico Captura (USD $)',
			'RecargaVentasMov' => 'Recarga Ventas Movistar (S/.)',
			'RecargaVentasClaro' => 'Recarga Ventas Claro (S/.)',
			'CABINA_Id' => 'Cabina',
			'CUENTA_Id' => 'Cuenta',
            'RecargaMovistar' => 'Recarga Movistar (S/.)',
            'RecargaClaro' => 'Recarga Claro (S/.)',
            'Trafico' => 'Trafico (S/.)',
            'FechaDep' => 'Fecha en que se hizo el Deposito',
            'HoraDep' => 'Hora en que se hizo el Deposito',
            'Depositante' => 'Nombre del Depositante',
            'TiempoCierre' => 'Tiempo de Cierre de Cabina (min)',
            'DiferencialBancario'=>"Diferencial Bancario (S/.) 'C-A'",
            'DifBancoCI'=>"Diferencial Bancario (S/.)",
            'DifMov'=>"Diferencial Brightstar Movistar (S/.)",
            'DifClaro'=>"Diferencial Brightstar Claro (S/.)",
            'DifSoles'=>"Diferencial Captura Soles (S/.)",
            'DifDollar'=>"Diferencial Captura Dollar (USD $)",
            'Paridad'=>"Paridad Cambiaria (S/.|$)",
            'TotalVentas'=>" Total  Ventas (S/.) 'A'",
            'Total'=>" Total  Ventas (S/.)",
            'Acumulado'=>"Acumulado Dif. Captura (USD $)",
            'MinutosCaptura'=>"Minutos segun Captura",
            'SobranteAcum'=>"Sobrante Acumulado (USD $)",
            'Sobrante'=>"Sobrante (USD $)",
            
		);
                
//		else if(Yii::app()->getModule('user')->user()->CABINA_Id == '17') return array(
//			'Id' => 'ID',
//			'Fecha' => 'Fecha del Balance',
//			'SaldoApMov' => 'Saldo Apertura Brightstar (S/.)',
//			'SaldoCierreMov' => 'Saldo Cierre Brightstar (S/.)',
//			'FijoLocal' => 'Fijo Local (S/.)',
//			'FijoProvincia' => 'Fijo Provincia (S/.)',
//			'FijoLima' => 'Fijo Lima (S/.)',
//			'Rural' => 'Rural (S/.)',
//			'Celular' => 'Celular (S/.)',
//			'LDI' => 'LDI (S/.)',
//			'RecargaCelularMov' => 'Recarga Celular Brightstar (S/.)',
//			'RecargaFonoYaMov' => 'Recarga Fono Brightstar (S/.)',
//			'OtrosServicios' => 'Otros Servicios (S/.)',
//			'MontoDeposito' => "Monto Deposito (S/.) 'B'",
//			'MontoDepositoOp' => "Monto Deposito (S/.)",
//			'NumRefDeposito' => 'Numero de Ref Deposito ',
//			'MontoBanco' => "Monto Banco (S/.) 'C'",
//			'ConciliacionBancaria' => "Conciliaci&oacute;n Bancaria (S/.) 'C-B'",
//			'ConciliacionBancariaCI' => "Conciliaci&oacute;n Bancaria (S/.)",
//			'FechaIngresoLlamadas' => 'Fecha Ingreso Llamadas',
//			'FechaIngresoDeposito' => 'Fecha Ingreso Deposito',
//			'TraficoCapturaDollar' => 'Trafico Captura (USD $)',
//			'RecargaVentasMov' => 'Recarga Ventas Brightstar (S/.)',
//			'CABINA_Id' => 'Cabina',
//			'CUENTA_Id' => 'Cuenta',
//            'RecargaMovistar' => 'Recarga Movistar (S/.)',
//            'RecargaClaro' => 'Recarga Claro (S/.)',
//            'Trafico' => 'Trafico (S/.)',
//            'FechaDep' => 'Fecha en que se hizo el Deposito',
//            'HoraDep' => 'Hora en que se hizo el Deposito',
//            'Depositante' => 'Nombre del Depositante',
//            'TiempoCierre' => 'Tiempo de Cierre de Cabina (min)',
//            'DiferencialBancario'=>"Diferencial Bancario (S/.) 'C-A'",
//            'DifBancoCI'=>"Diferencial Bancario (S/.)",
//            'DifMov'=>"Diferencial Brightstar Movistar (S/.)",
//            'DifClaro'=>"Diferencial Brightstar Claro (S/.)",
//            'DifSoles'=>"Diferencial Captura Soles (S/.)",
//            'DifDollar'=>"Diferencial Captura Dollar (USD $)",
//            'Paridad'=>"Paridad Cambiaria (S/.|$)",
//            'TotalVentas'=>" Total  Ventas (S/.) 'A'",
//            'Total'=>" Total  Ventas (S/.)",
//            'Acumulado'=>"Acumulado Dif. Captura (USD $)",
//            'MinutosCaptura'=>"Minutos segun Captura",
//            'SobranteAcum'=>"Sobrante Acumulado (USD $)",
//            'Sobrante'=>"Sobrante (USD $)",
//		);
                
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
     * @access public
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($post=null,$mes=null)
	{
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria=new CDbCriteria;
        $criteria->condition="status=1 AND Nombre!='ZPRUEBA' AND Nombre!='COMUN CABINA'";
        $criteria->compare('Id',$this->Id);
        $criteria->compare('Fecha',$this->Fecha,true);
        $criteria->compare('SaldoApMov',$this->SaldoApMov,true);		
        $criteria->compare('SaldoApClaro',$this->SaldoApClaro,true);
        $criteria->compare('SaldoCierreMov',$this->SaldoApMov,true);
        $criteria->compare('SaldoCierreClaro',$this->SaldoApClaro,true);
        $criteria->compare('FijoLocal',$this->FijoLocal,true);
        $criteria->compare('FijoProvincia',$this->FijoProvincia,true);
        $criteria->compare('FijoLima',$this->FijoLima,true);
        $criteria->compare('Rural',$this->Rural,true);
        $criteria->compare('Celular',$this->Celular,true);
        $criteria->compare('LDI',$this->LDI,true);
        $criteria->compare('RecargaCelularMov',$this->RecargaCelularMov,true);
        $criteria->compare('RecargaFonoYaMov',$this->RecargaFonoYaMov,true);
        $criteria->compare('RecargaCelularClaro',$this->RecargaCelularClaro,true);
        $criteria->compare('RecargaFonoClaro',$this->RecargaFonoClaro,true);
        $criteria->compare('OtrosServicios',$this->OtrosServicios,true);
        $criteria->compare('MontoDeposito',$this->MontoDeposito,true);
        $criteria->compare('NumRefDeposito',$this->NumRefDeposito,true);
        $criteria->compare('MontoBanco',$this->MontoBanco,true);
        $criteria->compare('ConciliacionBancaria',$this->ConciliacionBancaria,true);
        $criteria->compare('DiferencialBancario',$this->DiferencialBancario,true);
        $criteria->compare('FechaIngresoLlamadas',$this->FechaIngresoLlamadas,true);
        $criteria->compare('FechaIngresoDeposito',$this->FechaIngresoDeposito,true);
        $criteria->compare('TraficoCapturaDollar',$this->TraficoCapturaDollar,true);
        $criteria->compare('RecargaVentasMov',$this->RecargaVentasMov,true);
        $criteria->compare('RecargaVentasClaro',$this->RecargaVentasClaro,true);
        $criteria->compare('FechaDep',$this->FechaDep,true);
        $criteria->compare('HoraDep',$this->HoraDep,true);
        $criteria->compare('Depositante',$this->Depositante,true);
        $criteria->compare('TiempoCierre',$this->TiempoCierre,true);
        $criteria->compare('Acumulado',$this->Acumulado,true);
        $criteria->compare('MinutosCaptura',$this->MinutosCaptura,true);
        $criteria->compare('SobranteAcum',$this->SobranteAcum,true);
        $criteria->compare('CUENTA_Id',$this->CUENTA_Id,true);
        //la busqueda por cabinas
        $criteria->with =array('cABINA');
        $criteria->compare('cABINA.id', $this->CABINA_Id,FALSE);
        $criteria->compare('montoBanco',NULL,true);
        //Para calcular el numero de resultados por pagina en el gridview
        //para las diferentes vistas
        switch($post['vista'])
        {
            case 'Depositos':
                $criteria->condition.=" AND MontoDeposito IS NOT NULL AND MontoBanco IS NOT NULL";
                break;
            case 'Comision':
                $criteria->condition.=" AND MontoDeposito IS NOT NULL AND MontoBanco IS NOT NULL";
                break;
            default:
                break;
        }
        //Cambio la condicion dependiendo de los valores
        if(isset($mes) && $mes != null)
        {
            $criteria->condition.=" AND Fecha<='".$mes."-31' AND Fecha>='".$mes."-01'";
        }
        if(isset($post['balance']['formCabina']) && $post['balance']['formCabina'] != null)
        {
            $criteria->condition.=" AND CABINA_Id=".$post['balance']['formCabina'];
        }
        //la paginacion
        $pagina=Cabina::model()->count(array(
                'condition'=>'status=:status AND Id!=:Id AND Id!=:Id2',
                'params'=>array(
                    ':status'=>1,
                    ':Id'=>18,
                    ':Id2'=>19,
                    ),
                ));
        $orden="Fecha DESC, Nombre ASC";
        
        if(isset($mes) || isset($post['formCabina']))
        {
            $condition="Id>0";
            if($mes)
            {
                $condition.=" AND Fecha<='".$mes."-31' AND Fecha>='".$mes."-01'";
            }
            if($post['formCabina'])
            {
                $condition.=" AND CABINA_Id=".$post['formCabina'];
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

    /**
     * @access public
     */
	public function searchEs($vista=null,$idBalancesActualizados=NULL)
	{
        $criteria=new CDbCriteria;
        $criteria->condition = "status=1 AND Nombre!='ZPRUEBA' AND Nombre!='COMUN CABINA'";
        $criteria->compare('Fecha',$this->Fecha,true);
        $criteria->compare('SaldoApMov',$this->SaldoApMov,true);		
        $criteria->compare('SaldoApClaro',$this->SaldoApClaro,true);
        $criteria->compare('SaldoCierreMov',$this->SaldoApMov,true);
        $criteria->compare('SaldoCierreClaro',$this->SaldoApClaro,true);
        $criteria->compare('FijoLocal',$this->FijoLocal,true);
        $criteria->compare('FijoProvincia',$this->FijoProvincia,true);
        $criteria->compare('FijoLima',$this->FijoLima,true);
        $criteria->compare('Rural',$this->Rural,true);
        $criteria->compare('Celular',$this->Celular,true);
        $criteria->compare('LDI',$this->LDI,true);
        $criteria->compare('RecargaCelularMov',$this->RecargaCelularMov,true);
        $criteria->compare('RecargaFonoYaMov',$this->RecargaFonoYaMov,true);
        $criteria->compare('RecargaCelularClaro',$this->RecargaCelularClaro,true);
        $criteria->compare('RecargaFonoClaro',$this->RecargaFonoClaro,true);
        $criteria->compare('OtrosServicios',$this->OtrosServicios,true);
        $criteria->compare('MontoDeposito',$this->MontoDeposito,true);
        $criteria->compare('NumRefDeposito',$this->NumRefDeposito,true);
        $criteria->compare('MontoBanco',$this->MontoBanco,true);
        $criteria->compare('ConciliacionBancaria',$this->ConciliacionBancaria,true);
        $criteria->compare('DiferencialBancario',$this->DiferencialBancario,true);
        $criteria->compare('FechaIngresoLlamadas',$this->FechaIngresoLlamadas,true);
        $criteria->compare('FechaIngresoDeposito',$this->FechaIngresoDeposito,true);
        $criteria->compare('TraficoCapturaDollar',$this->TraficoCapturaDollar,true);
        $criteria->compare('RecargaVentasMov',$this->RecargaVentasMov,true);
        $criteria->compare('RecargaVentasClaro',$this->RecargaVentasClaro,true);
        $criteria->compare('FechaDep',$this->FechaDep,true);
        $criteria->compare('HoraDep',$this->HoraDep,true);
        $criteria->compare('Depositante',$this->Depositante,true);
        $criteria->compare('TiempoCierre',$this->TiempoCierre,true);
        $criteria->compare('Acumulado',$this->Acumulado,true);
        $criteria->compare('MinutosCaptura',$this->MinutosCaptura,true);
        $criteria->compare('SobranteAcum',$this->SobranteAcum,true);
        $criteria->compare('CUENTA_Id',$this->CUENTA_Id,true);

            
        //la busqueda por cabinas
        $criteria->with =array('cABINA');
        $criteria->compare('cABINA.id', $this->CABINA_Id,FALSE);
        $criteria->compare('montoBanco',NULL,true);

        $cabina=new Cabina();
        $pagina=$cabina->count(array(
            'condition'=>'status=:status AND Nombre!=:nombre AND Nombre!=:nombre2',
            'params'=>array(
            ':status'=>1,
            ':nombre'=>'ZPRUEBA',
            ':nombre2'=>'COMUN CABINA',
            ),
        ));

        if($vista=='mostrarFinal' && $idBalancesActualizados==NULL) 
        {
            $criteria->addCondition('CABINA_Id IS NULL');
            return new CActiveDataProvider($this, array(
                   'criteria' => $criteria,
                ));
        }
        elseif($vista == 'mostrarFinal' && $idBalancesActualizados!=NULL) 
        {
            $criteriaAux=new CDbCriteria;
            $arrayIds = explode('A',$idBalancesActualizados);
            $criteriaAux->addInCondition('Id', $arrayIds);
            return new CActiveDataProvider($this, array(
                'criteria' => $criteriaAux,
                'sort' => array('defaultOrder' => 'FechaDep DESC, HoraDep DESC'),
                'pagination' => array('pageSize' => $pagina),
                ));
        }
        elseif($vista == 'checkBanco') 
        {
            $criteria->addCondition('MontoBanco IS NULL');
            $criteria->addCondition('MontoDeposito IS NOT NULL');
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'sort' => array(
                    'defaultOrder'=>'FechaDep DESC, HoraDep DESC'
                    ),
                'pagination'=>array(
                    'pageSize'=>$pagina
                    ),
                ));
        }
        elseif($vista == 'admin')
        {
            if(Yii::app()->getModule('user')->user()->tipo == 1)
            {
                $criteria->addCondition("CABINA_Id=" . Yii::app()->getModule('user')->user()->CABINA_Id);
            }
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'sort'=>array(
                    'defaultOrder'=>'Fecha DESC, Nombre ASC'
                    ),
                'pagination'=>array(
                    'pageSize'=>$pagina
                    ),
                ));
        }
        elseif($vista == 'cicloIngresoTotal' && $idBalancesActualizados == NULL)
        {
            $criteriaAux=new CDbCriteria;
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
        elseif($vista == 'cicloIngresoTotal' && $idBalancesActualizados!=NULL && $idBalancesActualizados!="")
        {
            $fechaParametro = "$idBalancesActualizados";
            $criteriaAux=new CDbCriteria;
//            $criteriaAux->addCondition("Fecha='$fechaParametro'");
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
        elseif($vista=='pronostico')
        {
            $criteria->addCondition("Fecha = CURDATE()");
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'sort'=>array(
                    'defaultOrder'=>'Nombre ASC'
                    ),
                'pagination'=>array(
                    'pageSize'=>$pagina
                    ),
                ));
        }
        elseif($vista=='recargas' && $idBalancesActualizados!=NULL)
        {
            $criteria->addInCondition('id', $idBalancesActualizados);
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'sort'=>array(
                    'defaultOrder'=>'Nombre ASC'
                    ),
                'pagination'=>array(
                    'pageSize'=>$pagina
                    ),
                ));
        }
        elseif($vista=='recargas' && $idBalancesActualizados==NULL)
        {
            $criteria->addCondition("Fecha = CURDATE()");
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'sort'=>array(
                    'defaultOrder'=>'Nombre ASC'
                    ),
                'pagination'=>array(
                    'pageSize'=>$pagina
                    ),
                ));
        }
	}

    /**
     * @access public
     */
	public static function pintarDiff($montoDeposito,$montoBanco)
	{
        $resta = $montoDeposito-$montoBanco;
        if ($resta!=0)
        {
            //return array('style'=>'text-align: center; color: red;');
            return array('style'=>'color: red;');
        }
        else
        {
            return array('style'=>'text-align: center;');
        }
    }

    /**
     * @access public
     */
    public function disable()
	{
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria=new CDbCriteria;
        $criteria->condition="status=0 AND Nombre!='ZPRUEBA' AND Nombre!='COMUN CABINA'";
        $criteria->compare('Id',$this->Id);
        $criteria->compare('Fecha',$this->Fecha,true);
        $criteria->compare('SaldoApMov',$this->SaldoApMov,true);		
        $criteria->compare('SaldoApClaro',$this->SaldoApClaro,true);
        $criteria->compare('SaldoCierreMov',$this->SaldoApMov,true);
        $criteria->compare('SaldoCierreClaro',$this->SaldoApClaro,true);
        $criteria->compare('FijoLocal',$this->FijoLocal,true);
        $criteria->compare('FijoProvincia',$this->FijoProvincia,true);
        $criteria->compare('FijoLima',$this->FijoLima,true);
        $criteria->compare('Rural',$this->Rural,true);
        $criteria->compare('Celular',$this->Celular,true);
        $criteria->compare('LDI',$this->LDI,true);
        $criteria->compare('RecargaCelularMov',$this->RecargaCelularMov,true);
        $criteria->compare('RecargaFonoYaMov',$this->RecargaFonoYaMov,true);
        $criteria->compare('RecargaCelularClaro',$this->RecargaCelularClaro,true);
        $criteria->compare('RecargaFonoClaro',$this->RecargaFonoClaro,true);
        $criteria->compare('OtrosServicios',$this->OtrosServicios,true);
        $criteria->compare('MontoDeposito',$this->MontoDeposito,true);
        $criteria->compare('NumRefDeposito',$this->NumRefDeposito,true);
        $criteria->compare('MontoBanco',$this->MontoBanco,true);
        $criteria->compare('ConciliacionBancaria',$this->ConciliacionBancaria,true);
        $criteria->compare('DiferencialBancario',$this->DiferencialBancario,true);
        $criteria->compare('FechaIngresoLlamadas',$this->FechaIngresoLlamadas,true);
        $criteria->compare('FechaIngresoDeposito',$this->FechaIngresoDeposito,true);
        $criteria->compare('TraficoCapturaDollar',$this->TraficoCapturaDollar,true);
        $criteria->compare('RecargaVentasMov',$this->RecargaVentasMov,true);
        $criteria->compare('RecargaVentasClaro',$this->RecargaVentasClaro,true);
        $criteria->compare('FechaDep',$this->FechaDep,true);
        $criteria->compare('HoraDep',$this->HoraDep,true);
        $criteria->compare('Depositante',$this->Depositante,true);
        $criteria->compare('TiempoCierre',$this->TiempoCierre,true);

        //la busqueda por cabinas
        $criteria->with =array('cABINA');
        $criteria->compare('cABINA.id', $this->CABINA_Id,FALSE);
        $criteria->compare('montoBanco',NULL,true);
        //Para calcular el numero de resultados por pagina en el gridview
        $cabina=new Cabina();
        $pagina=$cabina->count(array(
            'condition'=>'status=:status AND Nombre!=:nombre AND Nombre!=:nombre2',
            'params'=>array(
                ':status'=>0,
                ':nombre'=>'ZPRUEBA',
                ':nombre2'=>'COMUN CABINA',
                ),
            ));

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'sort'=>array('defaultOrder'=>'Fecha DESC, Nombre ASC'),
                'pagination'=>array('pageSize'=>$pagina),
            ));

	}

    /**
     * @access public
     * @param date $fechaRegistro
     * @param $status
     */
    public static function totalVentas($fechaRegistro,$status="activas")
    {
        if($status=="activas")
        {
            $sql="SELECT TRUNCATE(SUM(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)),2) AS 'Total'
                  FROM balance AS b, cabina AS c
                  WHERE b.Fecha=:fechaRegistro AND b.CABINA_Id=c.Id AND c.status=1 AND b.CABINA_Id not in (18,19)
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }
        elseif($status=="inactivas")
        {
            $sql="SELECT TRUNCATE(SUM(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0)),2) AS 'Total'
                  FROM balance AS b, cabina  AS c
                  WHERE b.Fecha=:fechaRegistro AND b.CABINA_Id=c.Id AND c.status=0 AND b.CABINA_Id not in (18,19)
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }
        $resultado=Balance::model()->findBySql($sql,array(':fechaRegistro'=>"$fechaRegistro"));

        if($resultado == NULL)
            return '0.00';
        else
            return $resultado->getAttribute('Total');
    }

    /**
     * Metodo encargado de traer el monto de la venta en la fecha y cabina indicada
     * @param int cabina = id de la cabina a buscar
     * @param string compania = nombre de la compania
     * @param date fecha = la fecha que se quiere consultar
     * @return string con el monto encontrado
     */
    public static function getUltimoTotalVenta($cabina,$compania,$fecha)
    {
        if($compania=='movistar')
        {
            $sql="SELECT ifnull(sum(RecargaVentasMov),0) AS Total 
                  FROM balance 
                  WHERE Fecha='{$fecha}' AND CABINA_Id='{$cabina}' 
                  ORDER BY Fecha LIMIT 1;";
        }
        elseif($compania=='claro')
        {
            $sql="SELECT ifnull(sum(RecargaVentasClaro),0) AS Total 
                  FROM balance 
                  WHERE Fecha='{$fecha}' AND CABINA_Id='{$cabina}' 
                  ORDER BY Fecha LIMIT 1;";
        }
        $resultado = Balance::model()->findBySql($sql);

        if($resultado->getAttribute('Total') == NULL)
            return '0.00';
        else
            return $resultado->getAttribute('Total');
    }

    /**
     * Metodo encargado de sumar las ventas de una cabina en los ultimos treinta dias
     * @access public
     * @param int $id: id de la cabina
     * @param string $compania.
     * @param date $fecha.
     * @return string $resultado
     */
    public static function totalVentasMes($id,$compania,$fecha)
    {
        if($compania=='movistar')
        {
            $sql="SELECT SUM(X.ventas) as Total
                  FROM
                  (SELECT IFNULL(RecargaVentasMov,0) AS ventas 
                  FROM balance 
                  WHERE Fecha<='{$fecha}' AND CABINA_Id={$id} 
                  ORDER BY Fecha DESC LIMIT 30) X;";
        }
        elseif($compania=='claro')
        {
            $sql="SELECT SUM(X.ventas) as Total
                  FROM
                  (SELECT IFNULL(RecargaVentasClaro,0) AS ventas 
                  FROM balance 
                  WHERE Fecha<='{$fecha}' AND CABINA_Id={$id} 
                  ORDER BY Fecha DESC LIMIT 30) X;";
        }
        $resultado = Balance::model()->findBySql($sql);
        if($resultado->getAttribute('Total') == NULL)
            return '0.00';
        else
            return $resultado->getAttribute('Total');
    }

    /**
     * Metodo encargado de sumar las ventas de una cabina en el mes consultado
     * @access public
     * @param int $id: id de la cabina
     * @param string $compania.
     * @param date $fecha.
     * @return string $resultado
     */
    public static function totalVentasMesCabina($id,$compania,$fecha)
    {
        $array=explode('-',$fecha);
        if(count($array)>2)
        {
            list($year,$month,$day)=explode('-',$fecha);
        }
        else
        {
            list($year,$month)=explode('-', $fecha);
        }
        $fechaMax=$year."-".$month."-31";
        $fechaMin=$year."-".$month."-01";
        if($compania=='movistar')
        {
            $sql="SELECT IFNULL(SUM(RecargaVentasMov),0) AS Total 
                  FROM balance
                  WHERE Fecha>='{$fechaMin}' AND Fecha<='{$fechaMax}' AND CABINA_Id='{$id}';";
        }
        elseif($compania=='claro')
        {
            $sql="SELECT IFNULL(SUM(RecargaVentasClaro),0) AS Total 
                  FROM balance 
                  WHERE Fecha>='{$fechaMin}' AND Fecha<='{$fechaMax}' AND CABINA_Id='{$id}';";
        }
        $resultado = Balance::model()->findBySql($sql);
        if($resultado->getAttribute('Total') == NULL)
            return '0.00';
        else
            return $resultado->getAttribute('Total');
    }

    /**
     * @access public
     * @param $id
     * @param $compania
     * @param date $fecha
     * @return $resultado
     */
    public static function mayorVentaMes($id,$compania,$fecha)
    {
        if($compania=='movistar')
        {
            $sql="SELECT MAX(X.totales) as Total
                  FROM (SELECT IFNULL(RecargaVentasMov,0) as totales 
			FROM balance 
			WHERE Fecha<='{$fecha}' AND CABINA_Id='{$id}' ORDER BY Fecha DESC LIMIT 30) X;";

        }
        elseif($compania=='claro')
        {
            $sql="SELECT MAX(X.totales) as Total
                  FROM (SELECT IFNULL(RecargaVentasClaro,0) as totales 
			FROM balance 
			WHERE Fecha<='{$fecha}' AND CABINA_Id='{$id}' ORDER BY Fecha DESC LIMIT 30) X;";

        }
        $resultado = Balance::model()->findBySql($sql);
        if($resultado->getAttribute('Total') == NULL)
            return '0.00';
        else
            return $resultado->getAttribute('Total');
    }

    /**
     * Encargada de calcular la comision de una cabina en un mes especifico
     * @access public
     * @param string $compania.
     * @param int $id.
     * @param date $fecha.
     * @return string $comision.
     */
    public static function comisionCabina($compania,$id,$fecha)
    {
        if($id)
        {   
            $ventaMes=self::totalVentasMesCabina($id,$compania,$fecha);
            $comision=Yii::app()->format->formatDecimal($ventaMes-($ventaMes/1.06));
        }
        else
        {
            $comision="N/A";
        }
        return $comision;
    }

    /**
     * @access public
     * @param $compania
     * @param int $id
     * @param date $fecha
     * @return $resultado
     */
    public static function VtaMaxCabina($compania,$id,$fecha)
    {   
        $fechaIni=$fecha."-01";
        $fechaFin=$fecha."-30";
        if($compania=='movistar')
        {
            $sql="SELECT IFNULL(MAX(RecargaVentasMov),0) AS Total 
                  FROM balance 
                  WHERE Fecha>='{$fechaIni}' AND Fecha<='{$fechaFin}' AND CABINA_Id='{$id}' 
                  ORDER BY Fecha DESC;";
        }
        elseif($compania=='claro')
        {
            $sql="SELECT IFNULL(MAX(RecargaVentasClaro),0) AS Total 
                  FROM balance 
                  WHERE Fecha>='{$fechaIni}' AND Fecha<='{$fechaFin}' AND CABINA_Id='{$id}' 
                  ORDER BY Fecha DESC;";
        }
        $resultado = Balance::model()->findBySql($sql);
        if($resultado->getAttribute('Total') == NULL)
            return '0.00';
        else
            return $resultado->getAttribute('Total');
    }

    /**
     * @access public
     * @param date $fechaRegistro
     * @param $status
     * @return $resultado
     */
    public static function diferencialBancario($fechaRegistro,$status="activas")
    {
        if($status=="activas")
        {
            $sql="SELECT TRUNCATE(SUM(IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))),2) AS 'DifBancoCI'
                  FROM balance AS b, cabina AS c
                  WHERE b.Fecha=:fechaRegistro AND b.CABINA_Id=c.Id AND c.status=1 AND b.CABINA_Id!=18
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }
        elseif($status=="inactivas")
        {
            $sql="SELECT TRUNCATE(SUM(IFNULL(b.MontoBanco,0)-(IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)+IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0)+IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0)+IFNULL(b.OtrosServicios,0))),2) AS 'DifBancoCI'
                  FROM balance AS b, cabina AS c
                  WHERE b.Fecha=:fechaRegistro AND b.CABINA_Id=c.Id AND c.status=0 AND b.CABINA_Id!=18
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }
        $resultado=Balance::model()->findBySql($sql,array(':fechaRegistro'=>"$fechaRegistro"));
        if($resultado==NULL)
            return '0.00';    
        else
            return $resultado->getAttribute('DifBancoCI');
    }

    /**
     * @access public
     * @param date $fechaRegistro
     * @param $status
     * @return $resultado
     */
    public static function conciliacionBancaria($fechaRegistro,$status="activas")
    {
        if($status=="activas")
        {
            $sql="SELECT TRUNCATE(SUM(IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0)),2) AS 'ConciliacionBancariaCI'
                  FROM balance AS b, cabina AS c
                  WHERE b.Fecha=:fechaRegistro AND b.CABINA_Id=c.Id AND c.status=1 AND b.CABINA_Id!=18
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }
        elseif($status=="inactivas")
        {
            $sql="SELECT TRUNCATE(SUM(IFNULL(b.MontoBanco,0)-IFNULL(b.MontoDeposito,0)),2) AS 'ConciliacionBancariaCI'
                  FROM balance AS b, cabina AS c
                  WHERE b.Fecha=:fechaRegistro AND b.CABINA_Id=c.Id AND c.status=0 AND b.CABINA_Id!=18
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }
        $resultado=Balance::model()->findBySql($sql,array(':fechaRegistro'=>"$fechaRegistro"));
        if($resultado==NULL)
            return '0.00';
        else
            return $resultado->getAttribute('ConciliacionBancariaCI');
    }

    /**
     * @access public
     * @param date $fechaRegistro
     * @param $status
     * @return $reesultado
     */
    public static function diferencialBrightstarMovistar($fechaRegistro,$status="activas")
    {
        if($status=="activas")
        {
            $sql="SELECT TRUNCATE(SUM(IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0))),2) AS 'DifMov'
                  FROM balance AS b, cabina AS c
                  WHERE b.Fecha=:fechaRegistro AND b.CABINA_Id=c.Id AND c.status=1 AND b.CABINA_Id!=18
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }
        elseif($status=="inactivas")
        {
            $sql="SELECT TRUNCATE(SUM(IFNULL(b.RecargaVentasMov,0)-(IFNULL(b.RecargaCelularMov,0)+IFNULL(b.RecargaFonoYaMov,0))),2) AS 'DifMov'
                  FROM balance AS b, cabina AS c
                  WHERE b.Fecha=:fechaRegistro AND b.CABINA_Id=c.Id AND c.status=0 AND b.CABINA_Id!=18
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }
        $resultado=Balance::model()->findBySql($sql,array(':fechaRegistro'=>"$fechaRegistro"));
        if($resultado==NULL)
            return '0.00';
        else
            return $resultado->getAttribute('DifMov');
    }

    /**
     * @access public
     * @param date $fechaRegistro
     * @param $status
     * @return $resultado
     */        
    public static function diferencialBrightstarClaro($fechaRegistro,$status="activas")
    {
        if($status=="activas")
        {
            $sql="SELECT TRUNCATE(SUM(IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0))),2) AS 'DifClaro'
                  FROM balance AS b, cabina AS c
                  WHERE b.Fecha=:fechaRegistro AND b.CABINA_Id=c.Id AND c.status=1 AND b.CABINA_Id!=18
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }
        elseif($status=="inactivas")
        {
            $sql="SELECT TRUNCATE(SUM(IFNULL(b.RecargaVentasClaro,0)-(IFNULL(b.RecargaCelularClaro,0)+IFNULL(b.RecargaFonoClaro,0))),2) AS 'DifClaro'
                  FROM balance AS b, cabina AS c
                  WHERE b.Fecha=:fechaRegistro AND b.CABINA_Id=c.Id AND c.status=0 AND b.CABINA_Id!=18
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }
        $resultado=Balance::model()->findBySql($sql,array(':fechaRegistro'=>"$fechaRegistro"));
        if($resultado==NULL)
            return '0.00';
        else
            return $resultado->getAttribute('DifClaro');
    }

    /**
     * @access public
     * @param date $fechaRegistro
     * @param $status
     * @return $resultado
     */        
    public static function paridadCambiaria($fechaRegistro,$status="activas")
    {
        if($status=="activas")
        {
            $sql="SELECT TRUNCATE(IFNULL(p.Valor,0),2) AS 'Paridad'
                  FROM balance AS b
                  INNER JOIN paridad AS p
                  ON b.PARIDAD_Id=p.Id
                  INNER JOIN cabina AS c
                  ON b.CABINA_Id=c.Id
                  WHERE b.Fecha=:fechaRegistro AND c.status=1 AND b.CABINA_Id!=18
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }
        elseif($status=="inactivas")
        {
            $sql="SELECT TRUNCATE(IFNULL(p.Valor,0),2) AS 'Paridad'
                  FROM balance AS b 
                  INNER JOIN paridad AS p
                  ON b.PARIDAD_Id=p.Id
                  INNER JOIN cabina AS c
                  ON b.CABINA_Id=c.Id
                  WHERE b.Fecha=:fechaRegistro AND c.status=0 AND b.CABINA_Id!=18
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }
        $resultado=Balance::model()->findBySql($sql,array(':fechaRegistro'=>"$fechaRegistro"));
        if($resultado == NULL)
            return '0.00';
        else
            return $resultado->getAttribute('Paridad');
            
    }

    /**
     * @access public
     * @param date $fechaRegistro
     * @param $status
     * @return $resultado
     */  
    public static function diferencialCapturaSoles($fechaRegistro,$status="activas")
    {
        if($status=="activas")
        {
            $sql="SELECT TRUNCATE(SUM((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*IFNULL(p.Valor,0))),2) AS 'DifSoles'
                  FROM balance AS b
                  INNER JOIN paridad AS p
                  ON b.PARIDAD_Id=p.Id
                  INNER JOIN cabina AS c
                  ON b.CABINA_Id=c.Id
                  WHERE b.Fecha=:fechaRegistro AND c.status=1 AND b.CABINA_Id!=18
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }       
        elseif($status=="inactivas")
        {
            $sql="SELECT TRUNCATE(SUM((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0))-(IFNULL(b.TraficoCapturaDollar,0)*IFNULL(p.Valor,0))),2) AS 'DifSoles'
                  FROM balance AS b
                  INNER JOIN paridad AS p
                  ON b.PARIDAD_Id=p.Id
                  INNER JOIN cabina AS c
                  ON b.CABINA_Id=c.Id
                  WHERE b.Fecha=:fechaRegistro AND c.status=0 AND b.CABINA_Id!=18
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }            
        $resultado=Balance::model()->findBySql($sql,array(':fechaRegistro'=>"$fechaRegistro"));
        if($resultado==NULL)
            return '0.00';
        else
            return $resultado->getAttribute('DifSoles');
    }
    
    /**
     * @access public
     * @param date $fechaRegistro
     * @param $status
     * @return $resultado
     */
    public static function diferencialCapturaDollar($fechaRegistro,$status="activas")
    {
        if($status=="activas")
        {
            $sql="SELECT TRUNCATE(SUM((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)-IFNULL(b.TraficoCapturaDollar,0)*IFNULL(p.Valor,0))/IFNULL(p.Valor,0)),2) AS 'DifDollar'
                  FROM balance AS b
                  INNER JOIN paridad AS p
                  ON b.PARIDAD_Id=p.Id
                  INNER JOIN cabina AS c
                  ON b.CABINA_Id=c.Id
                  WHERE b.Fecha=:fechaRegistro AND c.status=1 AND b.CABINA_Id!=18
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }
        elseif($status=="inactivas")
        {
            $sql="SELECT TRUNCATE(SUM((IFNULL(b.FijoLocal,0)+IFNULL(b.FijoProvincia,0)+IFNULL(b.FijoLima,0)+IFNULL(b.Rural,0)+IFNULL(b.Celular,0)+IFNULL(b.LDI,0)-IFNULL(b.TraficoCapturaDollar,0)*IFNULL(p.Valor,0))/IFNULL(p.Valor,0)),2) AS 'DifDollar'
                  FROM balance AS b
                  INNER JOIN paridad AS p
                  ON b.PARIDAD_Id=p.Id
                  INNER JOIN cabina AS c
                  ON b.CABINA_Id=c.Id
                  WHERE b.Fecha=:fechaRegistro AND c.status=0 AND b.CABINA_Id!=18
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }
        $resultado=Balance::model()->findBySql($sql,array(':fechaRegistro'=>"$fechaRegistro"));
        if($resultado==NULL)
            return '0.00';
        else
            return $resultado->getAttribute('DifDollar');      
    }
    
    /**
     * @access public
     * @param date $fechaRegistro
     * @param $status
     * @return $resultado
     */
    public static function sobrante($fechaRegistro,$idCabina,$status="activas")
    {
        if($status=="activas")
        {
            $sql="SELECT TRUNCATE(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar),2) AS 'Sobrante'
                  FROM balance AS b
                  INNER JOIN cabina AS c
                  ON b.CABINA_Id=c.Id
                  WHERE b.Fecha=:fechaRegistro AND c.status=1 AND b.CABINA_Id=:cabinaID;";
        }
        elseif($status=="inactivas")
        {
            $sql="SELECT TRUNCATE(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar),2) AS 'Sobrante'
                  FROM balance AS b
                  INNER JOIN cabina AS c
                  ON b.CABINA_Id=c.Id
                  WHERE b.Fecha=:fechaRegistro AND c.status=0 AND b.CABINA_Id=:cabinaID;";
        }
        $resultado=Balance::model()->findBySql($sql,array(':fechaRegistro'=>"$fechaRegistro",':cabinaID'=>"$idCabina"));
        if($resultado==NULL)
            return 'Datos Incompletos';
        else
            return $resultado->getAttribute('Sobrante');      
    }

    /**
     * @access public
     * @param date $fechaRegistro
     * @param $status
     * @return $resultado
     */
    public static function sobranteTotal($fechaRegistro,$status="activas")
    {
        if($status=="activas")
        {
            $sql="SELECT TRUNCATE(SUM(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar)),2) AS 'Sobrante'
                  FROM balance AS b
                  INNER JOIN cabina AS c
                  ON b.CABINA_Id=c.Id
                  WHERE b.Fecha=:fechaRegistro AND c.status=1
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }
        elseif($status=="inactivas")
        {
            $sql="SELECT TRUNCATE(SUM(sobranteActual(b.Id,b.MontoBanco,b.RecargaVentasMov,b.RecargaVentasClaro,b.TraficoCapturaDollar)),2) AS 'Sobrante'
                  FROM balance AS b
                  INNER JOIN cabina AS c
                  ON b.CABINA_Id=c.Id
                  WHERE b.Fecha=:fechaRegistro AND c.status=0
                  GROUP BY b.Fecha
                  ORDER BY b.Fecha ASC;";
        }
        $resultado=Balance::model()->findBySql($sql,array(':fechaRegistro'=>"$fechaRegistro"));
        if($resultado==NULL)
            return 'Datos Incompletos';
        else
            return $resultado->getAttribute('Sobrante');      
    }

    /**
     * @access public
     * @param date $fechaRegistro
     * @param $status
     * @return $resultado
     */
    public static function acumuladoTotal($fechaRegistro,$status="activas")
    {
        if($status=="activas")
        {
            $sql="SELECT SUM(Acumulado) AS 'Acumulado'
                  FROM balance AS b
                  INNER JOIN cabina AS c
                  ON b.CABINA_Id=c.Id
                  WHERE b.Fecha=:fechaRegistro AND c.status=1
                  GROUP BY b.Fecha;";
        }
        elseif($status=="inactivas")
        {
            $sql="SELECT SUM(Acumulado) AS 'Acumulado'
                  FROM balance AS b
                  INNER JOIN cabina AS c
                  ON b.CABINA_Id=c.Id
                  WHERE b.Fecha=:fechaRegistro AND c.status=0
                  GROUP BY b.Fecha;";
        }
        $resultado=Balance::model()->findBySql($sql,array(':fechaRegistro'=>"$fechaRegistro"));
        if($resultado==NULL)
            return 'Datos Incompletos';
        else
            return $resultado->getAttribute('Acumulado');      
    }

    /**
     * @access public
     * @param date $fecharegistro
     * @param $status
     * @return $resultado
     */
    public static function sobranteAcumTotal($fechaRegistro,$status="activas")
    {
        if($status=="activas")
        {
            $sql="SELECT SUM(SobranteAcum) AS 'SobranteAcum'
                  FROM balance AS b
                  INNER JOIN cabina AS c
                  ON b.CABINA_Id=c.Id
                  WHERE b.Fecha=:fechaRegistro AND c.status=1
                  GROUP BY b.Fecha;";
        }
        elseif($status=="inactivas")
        {
            $sql="SELECT SUM(SobranteAcum) AS 'SobranteAcum'
                  FROM balance AS b
                  INNER JOIN cabina AS c
                  ON b.CABINA_Id=c.Id
                  WHERE b.Fecha=:fechaRegistro AND c.status=0
                  GROUP BY b.Fecha;";
        }
        $resultado=Balance::model()->findBySql($sql,array(':fechaRegistro'=>"$fechaRegistro"));
        if($resultado==NULL)
            return 'Datos Incompletos';
        else
            return $resultado->getAttribute('SobranteAcum');      
    }

    /**
     * Metodo encargado de regresar el saldo de apertura de una cabina y una fecha especifica
     * @access public
     * @param int $cabina id de la cabina
     * @param string $compania nombre de la compania consultada
     * @param date $fecha fecha de la consulta
     * @return string con el monto
     */
    public static function Saldo($cabina,$compania=null,$fecha)
    {
        $model=self::model()->find('CABINA_Id=:cabina AND Fecha=:fecha',array(':cabina'=>$cabina,':fecha'=>$fecha));
        $recargas=Recargas::getMontoRecarga($cabina,$compania,$fecha);
        $model->SaldoApMov=self::aCero($model->SaldoApMov);
        $model->RecargaVentasMov=self::aCero($model->RecargaVentasMov);
        $model->SaldoApClaro=self::aCero($model->SaldoApClaro);
        $model->RecargaVentasClaro=self::aCero($model->RecargaVentasClaro);
        if($compania==null || $compania=="movistar")
        {
            $resultado=$model->SaldoApMov;
        }
        else
        {
            $resultado=$model->SaldoApClaro;
        }
        if($resultado==NULL || $resultado<0)
            return '0.00';
        else
            return $resultado;
    }

    /**
     * Metodo encargado de regresar el saldo de cierre de una cabina y una fecha especifica
     * @access public 
     * @param int $cabina id de la cabina
     * @param string $compania nombre de la compania consultada
     * @param date $fecha fecha de la consulta 
     * @return string con el monto
     */
    public static function saldoCierre($cabina,$compania=null,$fecha)
    {
        $model=self::model()->find('CABINA_Id=:cabina AND Fecha=:fecha',array(':cabina'=>$cabina,':fecha'=>$fecha));
        $model->SaldoCierreMov=self::aCero($model->SaldoCierreMov);
        $model->SaldoCierreClaro=self::aCero($model->SaldoCierreClaro);
        if($compania==null || $compania=="movistar")
        {
            $resultado=$model->SaldoCierreMov;
        }
        else
        {
            $resultado=$model->SaldoCierreClaro;
        }
        if($resultado==NULL || $resultado<0)
            return '0.00';
        else
            return $resultado;
    }

    /**
     * @access private
     * @param $valor
     * @return $valor
     */
    private static function aCero($valor)
    {
        if($valor==null || $valor<0)
        {
            $valor='0.00';
        }
        return $valor;
    }

    /**
     * @access public
     * @param int $cabina
     * @param string $compania
     * @param date $fecha
     * @return $result
     */
    public static function saldoAperturaNumerica($cabina,$compania,$fecha)
    {
        $model=self::model()->find('CABINA_Id=:cabina AND Fecha=:fecha',array(':cabina'=>$cabina,':fecha'=>$fecha));
        if($compania==null || $compania=="movistar")
        {
            $resultado=$model->SaldoApMov;
        }
        elseif($compania=="claro")
        {
            $resultado=$model->SaldoApClaro;
        }
        if($resultado==NULL)
            return '0.00';
        else
            return $resultado;
    }

    /**
     * @access public
     * @param int $cabina
     * @param string $compania
     * @param date $fecha
     * @return $resultado
     */
    public static function DiasVentaMaxima($cabina,$compania,$fecha)
    {
        $saldoApertura=self::saldoAperturaNumerica($cabina,$compania,$fecha);
        if($saldoApertura<0)
        {
            $saldoApertura=0.00;
        }
        $totalVenta=self::getUltimoTotalVenta($cabina,$compania,$fecha);
        $recargas=Recargas::getMontoRecarga($cabina,$compania,$fecha);
        $mayorVenta=self::mayorVentaMes($cabina,$compania,$fecha);
        $monto=$saldoApertura-$totalVenta+$recargas;
        if($mayorVenta>0)
        {
            $resultado=$monto/$mayorVenta;
        }
        else
        {
            $resultado=$monto;
        }
        if($resultado<0)
            return "0.00";
        else
            return $resultado;
    }

    /**
     * @access public
     * @param date $fecha 
     * @param $cuenta
     * @return $sum
     */
    public static function sumMontoBanco($fecha,$cuenta)
    {
        $sum=Yii::app()->db->createCommand("SELECT SUM(b.montobanco) AS Ingresos
                                            FROM balance b, cabina c
                                            WHERE b.fechadep = '$fecha' AND c.Id=b.CABINA_Id AND c.status=1 AND b.CUENTA_Id = ".$cuenta)->queryScalar();

        if($sum===NULL)
            return 'Datos Incompletos';
        else
            return $sum;
    }

    /**
    * Metodo encargado de mostrar la fecha recibida por un post, de lo contrario muestra a ultima fecha de base de datos
    * @access public
    * @param date fecha = fecha que se va a mostrar
    * @return string con el mes si el parametro no es nulo y un date con la ultima fecha de base de datos si lo es
    */
    public static function fecha($fecha)
    {
        if($fecha)
        {
            $mes=Utility::monthName($fecha."-01");
        }
        else
        {
            $fecha=self::model()->findBySql('SELECT Fecha FROM balance ORDER BY Fecha DESC limit 1');
            $mes=$fecha->Fecha;
        }
        return $mes;
    } 
    
}