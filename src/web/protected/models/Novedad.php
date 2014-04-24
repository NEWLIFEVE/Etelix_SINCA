<?php

/**
 * This is the model class for table "novedad".
 *
 * The followings are the available columns in table 'novedad':
 * @property integer $Id
 * @property string $Fecha
 * @property string $Hora
 * @property string $Descripcion
 * @property string $Num
 * @property string $Puesto
 * @property integer $users_id
 * @property integer $TIPONOVEDAD_Id
 *
 * The followings are the available model relations:
 * @property Tiponovedad $nOVEDAD
 * @property Users $users
 */
class Novedad extends CActiveRecord
{
    public $User;
    public $Cabina;
    public $status;
    public $TipoNovedad;
    public $TIPOTELEFONO_Id;
    public $Falla;
    public $Locutorio;
    public $Destino;
    public $PuestoTotal;


    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'novedad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Descripcion, users_id, TIPONOVEDAD_Id', 'required'),        
			array('users_id, TIPONOVEDAD_Id, Num, Puesto', 'numerical', 'integerOnly'=>true),
			array('Descripcion', 'length', 'max'=>450),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Fecha, Hora, Id, Descripcion, Num, Puesto, users_id, TIPONOVEDAD_Id', 'safe', 'on'=>'search'),
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
			'tIPONOVEDAD' => array(self::BELONGS_TO, 'Tiponovedad', 'TIPONOVEDAD_Id'),
			'users' => array(self::BELONGS_TO, 'Users', 'users_id'),
                        'novedadTipotelefonos' => array(self::HAS_MANY, 'NovedadTipotelefono', 'NOVEDAD_Id'),
                        'novedadLocutorios' => array(self::HAS_MANY, 'NovedadLocutorio', 'NOVEDAD_Id'),
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
			'Hora' => 'Hora',
			'Descripcion' => 'Descripción',
			'Num' => 'Número Telefonico',
                        'Puesto'=>'Puesto de la Cabina',
			'users_id' => 'Usuario',
			'TIPONOVEDAD_Id' => 'Tipo de Novedad',
                        'TIPOTELEFONO_Id' => 'Tipo de Telefono',
                        'Observaciones' => 'Observaciones',
                        'status' => 'Estatus',
                        'Locutorio'=>'Locutorio(s)',
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
                $criteria->compare('Fecha',$this->Fecha);
		$criteria->compare('Hora',$this->Hora);
		$criteria->compare('Descripcion',$this->Descripcion,true);
		$criteria->compare('Num',$this->Num,true);
		$criteria->compare('Puesto',$this->Puesto,true);
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('TIPONOVEDAD_Id',$this->TIPONOVEDAD_Id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array('defaultOrder'=>'Fecha DESC'),
		));
	}
        
        public function searchEs($vista=null,$status=null,$mes=null,$cabina=null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Id',$this->Id);
		$criteria->compare('Fecha',$this->Fecha);
		$criteria->compare('Hora',$this->Hora);
		$criteria->compare('Descripcion',$this->Descripcion,true);
		$criteria->compare('Num',$this->Num,true);
                $criteria->compare('Puesto',$this->Puesto,true);
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('TIPONOVEDAD_Id',$this->TIPONOVEDAD_Id);

                if($vista=='admin')
                {
                    if(Yii::app()->getModule('user')->user()->tipo==1){
                        $criteria->addCondition("users_id=".Yii::app()->getModule('user')->user()->id);
                    }    
                }
                
                if($vista=='estadoNovdad')
                {
                    
                    if(isset($mes) && $mes != '')
                        $criteria->addCondition("(Fecha <= '$mes' AND Fecha >= DATE_SUB('$mes', INTERVAL 6 DAY))"); 
                    
                    if(isset($cabina) && $cabina != ''){
                        $criteria->join ='INNER JOIN users as u ON u.id = t.users_id';
                        $criteria->addCondition("(Fecha <= '$mes' AND Fecha >= DATE_SUB('$mes', INTERVAL 6 DAY))"); 
                        if(isset($status) && $status != '')
                           $criteria->addCondition("(t.Fecha <= '$mes' AND t.Fecha >= DATE_SUB('$mes', INTERVAL 6 DAY)) AND t.STATUS_Id=$status AND u.CABINA_Id=$cabina");  
                        else
                           $criteria->addCondition("(t.Fecha <= '$mes' AND t.Fecha >= DATE_SUB('$mes', INTERVAL 6 DAY)) AND u.CABINA_Id=$cabina");   
                    }elseif((!isset($cabina) && $cabina == '') && (isset($status) && $status != '')){
                        $criteria->addCondition("Fecha <= '$mes' AND Fecha >= DATE_SUB('$mes', INTERVAL 6 DAY) AND STATUS_Id=$status");
                    }
                    
                    
                }
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array('defaultOrder'=>'Fecha DESC, STATUS_ID ASC'),
		));
	}
        
        public static function compareIsStatusFromNovedad($idNovedad,$valorStatusComparar)
        {
            $resulset=Detallegasto::model()->find("Id=:idNovedad AND status=:valorStatusComparar",
                array(
                    ":idNovedad"=>$idNovedad,
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
        
        public static function getLocutorioOldTable($cabina_id,$tipo_novedad,$fecha)
        {
          $model_novedad = Novedad::model()->findBySql("SELECT DISTINCT(n.Puesto) as Puesto
                                                        FROM novedad as n
                                                        INNER JOIN tiponovedad as t ON t.Id = n.TIPONOVEDAD_Id
                                                        INNER JOIN users as u ON u.id = n.users_id
                                                        WHERE u.CABINA_Id = $cabina_id
                                                        AND t.Nombre = '$tipo_novedad'
                                                        AND n.Fecha = '$fecha'
                                                        AND n.Puesto != 0;");
          $puesto = $model_novedad;
          if($puesto == NULL){
              return false;
          }else{
              return $model_novedad->Puesto;  
          }
        }
        
        //OBTENER LOS TOTALES POR CABINA Y LOCUTORIO
        public static function getLocutorioTotalesCabinas($cabina_id,$fecha)
        {
          $model_novedad = Novedad::model()->findBySql("SELECT IF(COUNT(n.Id)=0,'',COUNT(n.Id)) as PuestoTotal
                                                        FROM novedad as n
                                                        INNER JOIN users as u ON u.id = n.users_id
                                                        WHERE u.CABINA_Id = $cabina_id
                                                        AND n.Fecha = '$fecha';");
          $puesto = $model_novedad;
          if($puesto == NULL){
              return false;
          }else{
              return $model_novedad->PuestoTotal;  
          }
        }
        
        //TOTALES DE FALLAS POR DIA
        public static function getTotalesDias($fecha)
        {
          $model_novedad = Novedad::model()->findBySql("SELECT COUNT(n.Id) as PuestoTotal
                                                        FROM novedad as n
                                                        INNER JOIN users as u ON u.id = n.users_id
                                                        INNER JOIN cabina as c ON c.Id = u.CABINA_Id
                                                        WHERE n.Fecha = '$fecha';");
          $puesto = $model_novedad;
          if($puesto == NULL){
              return '';
          }else{
              return $model_novedad->PuestoTotal;  
          }
        }
        
        //OBTENER LAS FALLAS TOTALES POR CABINA
        public static function getTotalesCabina($cabina_id,$fecha_primera,$fecha_ultima)
        {
          $model_novedad = Novedad::model()->findBySql("SELECT COUNT(n.Id) as PuestoTotal
                                                        FROM novedad as n
                                                        INNER JOIN users as u ON u.id = n.users_id
                                                        WHERE u.CABINA_Id = $cabina_id
                                                        AND n.Fecha <= '$fecha_ultima'
                                                        AND n.Fecha >= '$fecha_primera';");
          $puesto = $model_novedad;
          if($puesto == NULL){
              return '';
          }else{
              return $model_novedad->PuestoTotal;  
          }
        }
        
        //OBTENER LOS LOCUTORIOS DE LA NUEVA TABLA CON RELACION MUCHOS A MUCHOS
        public static function getLocutorioNewTable($cabina_id,$tipo_novedad,$fecha)
        {
          
            $model = NovedadLocutorio::model()->findAllBySql("SELECT nl.LOCUTORIO_Id
                                                  FROM novedad_locutorio as nl
                                                  INNER JOIN novedad as n ON n.Id = nl.NOVEDAD_Id
                                                  INNER JOIN tiponovedad as t ON t.Id = n.TIPONOVEDAD_Id
                                                  INNER JOIN users as u ON u.id = n.users_id
                                                  WHERE u.CABINA_Id = $cabina_id
                                                  AND t.Nombre = '$tipo_novedad'
                                                  AND n.Fecha = '$fecha'
                                                  ORDER BY nl.LOCUTORIO_Id;");
            foreach ($model as $key => $value) {
                $puestos[$key] = $value->LOCUTORIO_Id;
            }
            if(!isset($puestos[0]))
              $puestos_string = '';
            elseif(isset($puestos[0]) && $puestos[0] != 11)
              $puestos_string = implode(",", $puestos);  
            elseif($puestos[0] == 11)
              $puestos_string = 'Todas';  

            return $puestos_string;

          
        }
        
        public static function getStatus($status)
        {
            if($status == 1)
                return 'Abierto';
            else
                return 'Cerrado';
        }
        
        public static function changeObservacionByStatus($status,$id,$observacion){
            
		if($status == 1)
		{
		   return CHtml::textArea("Observaciones_$id",$observacion,array("style"=>"width:98%;height: 50px;resize: none;"));	
		}
                else
                {
                    return $observacion;
                }
        }
        
        public static function changeStatusByStatus($status,$id,$status_actual){
            
		if($status == 1)
		{
		   return CHtml::dropDownList("status_$id", $status_actual, NovedadStatus::getListStatus(), array("style"=>"width:70px;","class"=>"Estatus"));	
		}
                else
                {
                    return NovedadStatus::getStatusName($status_actual);
                }
        }
        
}