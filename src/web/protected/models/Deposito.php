<?php

/**
 * This is the model class for table "deposito".
 *
 * The followings are the available columns in table 'deposito':
 * @property integer $id
 * @property string $Fecha
 * @property string $Hora
 * @property string $MontoDep
 * @property string $MontoBanco
 * @property string $NumRef
 * @property string $Depositante
 * @property integer $CUENTA_Id
 * @property integer $CABINA_Id
 *
 * The followings are the available model relations:
 * @property Cuenta $cUENTA
 * @property Cabina $cABINA
 */
class Deposito extends CActiveRecord
{

        public $TotalVentas;
        public $DiferencialBancario;
        public $ConciliacionBancaria;
        public $Cabina;
        public $MontoDeposito;
        public $NumRefDeposito;
        public $FechaIngresoDeposito;


        public function tableName()
	{
		return 'deposito';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Fecha, FechaCorrespondiente, Hora, MontoDep, NumRef, CUENTA_Id, CABINA_Id', 'required'),
			array('CUENTA_Id, CABINA_Id', 'numerical', 'integerOnly'=>true),
			array('MontoDep, MontoBanco', 'length', 'max'=>15),
			array('NumRef, Depositante', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, Fecha, FechaCorrespondiente, Hora, MontoDep, MontoBanco, NumRef, Depositante, CUENTA_Id, CABINA_Id', 'safe', 'on'=>'search'),
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
			'cABINA' => array(self::BELONGS_TO, 'Cabina', 'CABINA_Id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'Fecha' => 'Fecha',
			'CUENTA_Id' => 'Cuenta',
			'CABINA_Id' => 'Cabina',
                        'TotalVentas' => "Total Ventas (S/.) 'A'",
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

		$criteria->compare('id',$this->id);
		$criteria->compare('Fecha',$this->Fecha,true);
                $criteria->compare('FechaCorrespondiente',$this->Fecha,true);
		$criteria->compare('Hora',$this->Hora,true);
		$criteria->compare('MontoDep',$this->MontoDep,true);
		$criteria->compare('MontoBanco',$this->MontoBanco,true);
		$criteria->compare('NumRef',$this->NumRef,true);
		$criteria->compare('Depositante',$this->Depositante,true);
		$criteria->compare('CUENTA_Id',$this->CUENTA_Id);
		$criteria->compare('CABINA_Id',$this->CABINA_Id);
                $criteria->with =array('cABINA');
                $criteria->condition = "cABINA.status = 1";
                $criteria->group='FechaCorrespondiente,CABINA_Id';
                
                if($cabina!=NULL)
                    $criteria->addCondition("CABINA_Id=$cabina");
                if($mes!=NULL)
                    $criteria->addCondition("FechaCorrespondiente<='".$mes."-31' AND FechaCorrespondiente>='".$mes."-01'");
                
                $pagina=Cabina::model()->count(array(
                                'condition'=>'status=:status AND Id!=:Id AND Id!=:Id2',
                                'params'=>array(
                                    ':status'=>1,
                                    ':Id'=>18,
                                    ':Id2'=>19,
                                    ),
                                ));

                        $orden="FechaCorrespondiente DESC, cABINA.Nombre ASC";

                 if($post=='MontoBanco') 
                {
                    $criteria->addCondition("MontoBanco IS NULL");
                }        
                        
                if($post=='mostrarFinal' && $idBalancesActualizados==NULL) 
                {
                    $criteria->addCondition('CABINA_Id IS NULL');
                    return new CActiveDataProvider($this, array(
                           'criteria' => $criteria,
                        ));
                }
                elseif($post == 'mostrarFinal' && $idBalancesActualizados!=NULL) 
                {
                    $criteriaAux=new CDbCriteria;
                    $arrayIds = explode('A',$idBalancesActualizados);
                    $criteriaAux->addInCondition('id', $arrayIds);
                    return new CActiveDataProvider($this, array(
                        'criteria' => $criteriaAux,
                        'sort' => array('defaultOrder' => 'Fecha ASC, Hora ASC'),
                        'pagination' => array('pageSize' => $pagina),
                        ));
                }
                
                if(isset($mes) || isset($cabina))
                {
                    $condition="id>0";
                    if($mes)
                    {
                        $condition.=" AND FechaCorrespondiente<='".$mes."-31' AND FechaCorrespondiente>='".$mes."-01'";
                    }
                    if($cabina)
                    {
                        $condition.=" AND CABINA_Id=".$cabina;
                    }
                    $pagina=self::model()->count($condition);
                    $orden="FechaCorrespondiente DESC, cABINA.Nombre ASC";
                }
                
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array('defaultOrder'=>$orden),
                        'pagination'=>array('pageSize'=>$pagina),
		));
	}
        
        public function disable()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('Fecha',$this->Fecha,true);
                $criteria->compare('FechaCorrespondiente',$this->Fecha,true);
		$criteria->compare('Hora',$this->Hora,true);
		$criteria->compare('MontoDep',$this->MontoDep,true);
		$criteria->compare('MontoBanco',$this->MontoBanco,true);
		$criteria->compare('NumRef',$this->NumRef,true);
		$criteria->compare('Depositante',$this->Depositante,true);
		$criteria->compare('CUENTA_Id',$this->CUENTA_Id);
		$criteria->compare('CABINA_Id',$this->CABINA_Id);
                $criteria->with =array('cABINA');
                $criteria->condition = "cABINA.status = 0";
                $criteria->group='FechaCorrespondiente,CABINA_Id';
                
                $pagina=Cabina::model()->count(array(
                        'condition'=>'status=:status AND Id!=:Id AND Id!=:Id2',
                        'params'=>array(
                            ':status'=>0,
                            ':Id'=>18,
                            ':Id2'=>19,
                            ),
                        ));
                $orden="FechaCorrespondiente DESC, cABINA.Nombre ASC";

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
	 * @return Deposito the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getDeposito($fecha,$cabina)
	{
            $model = self::model()->findBySql("SELECT SUM(MontoDep) as MontoDep
                                               FROM deposito 
                                               WHERE FechaCorrespondiente = '$fecha' AND CABINA_Id = $cabina;");
            if($model != NULL){
                if($model->MontoDep != NULL){
                    return $model->MontoDep;
                }else{
                    return '0.00';
                }
            }else{
                return '0.00';
            }
	}
        
        public static function getMontoBanco($fecha,$cabina)
	{
            $model = self::model()->findBySql("SELECT SUM(MontoBanco) as MontoBanco
                                               FROM deposito 
                                               WHERE FechaCorrespondiente = '$fecha' AND CABINA_Id = $cabina;");
            if($model != NULL){
                if($model->MontoBanco != NULL){
                    return $model->MontoBanco;
                }else{
                    return '0.00';
                }
            }else{
                return '0.00';
            }
            
	}
        
        public static function getNumRef($fecha,$cabina)
	{
            $model = self::model()->findBySql("SELECT NumRef
                                               FROM deposito 
                                               WHERE FechaCorrespondiente = '$fecha' AND CABINA_Id = $cabina;");
            if($model != NULL){
                if($model->NumRef != NULL){
                    return $model->NumRef;
                }else{
                    return '';
                }
            }else{
                return '';
            }
            
	}
        
        
        public static function getDataDeposito($fecha,$cabina,$atributo=NULL)
	{
            if($atributo == NULL){
                $model = self::model()->findBySql("SELECT *
                                                   FROM deposito 
                                                   WHERE FechaCorrespondiente = '$fecha' AND CABINA_Id = $cabina;");

                return $model;
            }elseif($atributo != NULL){
                
                $model = self::model()->findBySql("SELECT $atributo
                                                   FROM deposito 
                                                   WHERE FechaCorrespondiente = '$fecha' AND CABINA_Id = $cabina;");

                if($model == NULL){
                    return '';
                }elseif($model != NULL){
                    
                    if($model->$atributo == NULL){
                        return '';
                    }elseif($model->$atributo != NULL){
                         return $model->$atributo;
                    }
                    
                    
                }
                
            
            }
	}
        
        public static function valueNull($valor)
	{

           if($valor != NULL)
                return $valor;
            else
                return '0.00';
	}
        
        public static function sumMontoBanco($fecha,$cuenta)
        {
            $sum=Yii::app()->db->createCommand("SELECT SUM(d.MontoBanco) AS Ingresos
                                                FROM deposito d, cabina c
                                                WHERE d.Fecha = '$fecha' AND c.Id=d.CABINA_Id AND c.status=1 AND d.CUENTA_Id = ".$cuenta)->queryScalar();

            if($sum===NULL)
                return 'Datos Incompletos';
            else
                return $sum;
        }

}
