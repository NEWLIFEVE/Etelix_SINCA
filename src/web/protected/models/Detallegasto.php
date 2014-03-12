<?php

/**
 * This is the model class for table "detallegasto".
 *
 * The followings are the available columns in table 'detallegasto':
 * @property integer $Id
 * @property string $Monto
 * @property string $FechaMes
 * @property string $FechaVenc
 * @property string $Descripcion
 * @property integer $status
 * @property integer $TransferenciaPago
 * @property integer $FechaTransf
 * @property integer $beneficiario
 * @property integer $moneda
 * @property integer $USERS_Id
 * @property integer $TIPOGASTO_Id
 * @property integer $CABINA_Id
 * @property integer $CUENTA_Id
 *
 * The followings are the available model relations:
 * @property Tipogasto $tIPOGASTO
 * @property Users $uSERS
 */
class Detallegasto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Detallegasto the static model class
	 */
    
    public $nombreTipoDetalle;
    public $OrdenDePago;
    public $Aprobada;
    public $Pagada;
    public $vista;
    public $sum;
    public $Cabina;
    public $Cuenta;
    public $Tipogasto;
    public $TSoles;
    public $TDolares;
    public $MontoD;
    public $MontoS;
    public $MontoDolares;
    public $MontoSoles;
    public $category;
    public $categoria;
    //

    /**
    *
    */
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detallegasto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Monto, FechaMes, status,CABINA_Id,moneda,category, USERS_Id, TIPOGASTO_Id,CUENTA_Id,beneficiario', 'required'),
			array('status, USERS_Id, TIPOGASTO_Id, CABINA_Id, moneda,category,CUENTA_Id', 'numerical', 'integerOnly'=>true),
			array('Monto', 'length', 'max'=>15),
			array('Descripcion, TransferenciaPago, beneficiario', 'length', 'max'=>245),
			array('FechaVenc', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, Monto, FechaMes, FechaVenc, nombreTipoDetalle, Descripcion, status, TransferenciaPago, FechaTransf, beneficiario, USERS_Id, TIPOGASTO_Id, CABINA_Id, CUENTA_Id', 'safe', 'on'=>'search'),
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
			'tIPOGASTO' => array(self::BELONGS_TO, 'Tipogasto', 'TIPOGASTO_Id'),
			'uSERS' => array(self::BELONGS_TO, 'Users', 'USERS_Id'),
			'cABINA' => array(self::BELONGS_TO, 'Cabina', 'CABINA_Id'),
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
			'Monto' => 'Monto',
			'FechaMes' => 'Mes',
			'FechaVenc' => 'Fecha de Venc',
			'Descripcion' => 'Descripcion',
			'status' => 'Status',
			'USERS_Id' => 'Responsable',
			'TIPOGASTO_Id' => 'Tipo de gasto',
			'CABINA_Id' => 'Cabina',
			'CUENTA_Id' => 'Cuenta',
                        'OrdenDePago' => 'Orden de pago',
                        'Aprobada' => 'Aprobada',
                        'Pagada' => 'Pagada',
                        'TransferenciaPago' => 'Nro. Tranferencia',
                        'FechaTransf' => 'Fecha Tranferencia',
                        'beneficiario' => 'Beneficiario',
                        'category' => 'Categoria',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($vista=NULL,$cabina=NULL,$fecha=NULL,$status=NULL,$idBalancesActualizados=NULL)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$criteria->compare('Id',$this->Id);
		$criteria->compare('Monto',$this->Monto,true);
		$criteria->compare('FechaMes',$this->FechaMes,true);
		$criteria->compare('FechaVenc',$this->FechaVenc,true);
		$criteria->compare('Descripcion',$this->Descripcion,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('USERS_Id',$this->USERS_Id);
		$criteria->compare('TIPOGASTO_Id',$this->TIPOGASTO_Id);
		$criteria->compare('CABINA_Id',$this->CABINA_Id);
        if($vista == 'estadoDeGastos')
        {
            if($cabina!=NULL)
                $criteria->addCondition("CABINA_Id=$cabina");
            if($fecha!=NULL)
                $criteria->addCondition("FechaMes='$fecha'");
            if($status!=NULL)
                $criteria->addCondition("status=$status");
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'sort'=>array(
                    'defaultOrder'=>'Id ASC, status ASC'
                    ),
                'pagination'=>array(
                    'pageSize'=>30
                    ),
                ));
        }
        elseif($vista == 'mostrarFinal' && $idBalancesActualizados == NULL)
        {
            $criteriaAux=new CDbCriteria;
            $criteriaAux->addCondition("Id=0");
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteriaAux,
                ));
        }
        elseif($vista == 'mostrarFinal' && $idBalancesActualizados!=NULL && $idBalancesActualizados!="")
        {
            $criteriaAux=new CDbCriteria;
            $arrayIds=explode('A',$idBalancesActualizados);
            $criteriaAux->addInCondition('Id', $arrayIds);
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteriaAux,
                'sort'=>array(
                    'defaultOrder'=>'Id ASC, status ASC'
                    ),
                'pagination'=>array(
                    'pageSize'=>12
                    ),
                ));
        }
        else
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                ));
    }

    /**
    *
    */
    public static function compareIsStatusFromGasto($idDetalleGasto,$valorStatusComparar)
    {
        $resulset=Detallegasto::model()->find("Id=:idDetalleGasto AND status=:valorStatusComparar",
            array(
                ":idDetalleGasto"=>$idDetalleGasto,
                ":valorStatusComparar"=>$valorStatusComparar
                )
            );
        if($resulset!=NULL)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
    *
    */
    public static function estadoGasto($status)
    {
        switch($status)
        {
            case 1:
                return 'orden de pago';
                break;
            case 2:
                return 'aprobado';
                break;
            case 3:
                return 'pagado';
                break;
        }
    }
    
    /**
    *
    */
    public static function monedaGasto($moneda)
    {     
        $mon = '';
        switch($moneda)
        {    			
            case 1:
                $mon = 'USD$';
                break;
            case 2:
                $mon =  'S/.';
                break;
            case null:
                $mon =  'S/.';
                break;
        }
        
        return $mon;
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

        
    /**
    *
    */        
    public static function sumGastosBanco($fecha,$cuenta)
    {
            /*REVISAR*/
//        $fecha= "'".$fecha."'";
//        $sql="SELECT SUM(monto) AS Egresos 
//              FROM detallegasto
//              WHERE status = 3 AND fechatransf = :fecha;";
//       
//        $resultado = Detallegasto::model()->findBySql($sql,array(':fecha'=>$fecha));
        $sum = Yii::app()->db->createCommand("SELECT SUM(d.monto) FROM detallegasto d, cabina c 
            WHERE d.status = 3 AND c.Id = d.CABINA_Id AND c.status = 1 AND d.fechatransf = '$fecha' AND d.CUENTA_Id = ".$cuenta)->queryScalar();
                
        if($sum === NULL){
            return 'Datos Incompletos';
        }
        else{
            return $sum;    
            //return $resultado->getAttribute('Egresos');    
        }
    }
}