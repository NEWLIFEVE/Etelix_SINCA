<?php

/**
 * This is the model class for table "cabina".
 *
 * The followings are the available columns in table 'cabina':
 * @property integer $Id
 * @property string $Nombre
 * @property string $Codigo
 * @property string $status
 * @property string $HoraIni
 * @property string $HoraFin
 * @property string $HoraIniDom
 * @property string $HoraFinDom
 *
 * The followings are the available model relations:
 * @property Balance[] $balances
 * @property Comparativos[] $comparativoses
 * @property Operador[] $operadors
 */
class Cabina extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cabina the static model class
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
		return 'cabina';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Nombre, Id', 'required'),
			array('Nombre, Codigo', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, Nombre, Codigo, status, HoraIni, HoraFin, HoraIniDom, HoraFinDom', 'safe', 'on'=>'search'),
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
			'balances' => array(self::HAS_MANY, 'Balance', 'CABINA_Id'),
			'comparativoses' => array(self::HAS_MANY, 'Comparativos', 'CABINA_Id'),
			'operadors' => array(self::HAS_MANY, 'Operador', 'CABINA_Id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'Cabina',
//			'Id' => 'ID',
			'Nombre' => 'Nombre',
			'Codigo' => 'Codigo Brightstar',
			'status' => 'Estatus',            
			'HoraIni' => 'Hora Inicio',            
			'HoraFin' => 'Hora Fin',            
			'HoraIniDom' => 'Hora Inicio Domingo',            
			'HoraFinDom' => 'Hora Fin Domingo',            
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
                $criteria->condition="status=1 AND Nombre!='ZPRUEBA' AND Nombre!='COMUN CABINA'";
		$criteria->compare('Id',$this->Id);
		$criteria->compare('Nombre',$this->Nombre,true);
		$criteria->compare('Codigo',$this->Codigo,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('HoraIni',$this->HoraIni,true);
		$criteria->compare('HoraFin',$this->status,true);
		$criteria->compare('HoraIniDom',$this->HoraIniDom,true);
		$criteria->compare('HoraFinDom',$this->HoraFinDom,true);
                 
                $orden="Nombre ASC";
                         
                $pagina=Cabina::model()->count(array(
                'condition'=>'status=:status AND Id!=:Id AND Id!=:Id2',
                'params'=>array(
                    ':status'=>1,
                    ':Id'=>18,
                    ':Id2'=>19,
                    ),
                ));
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array('defaultOrder'=>$orden),
                        'pagination'=>array('pageSize'=>$pagina),
		));
	}

	public static function getListCabina()
	{
		return CHtml::listData(Cabina::model()->findAll('status=:status AND Nombre!=:nombre AND Nombre!=:nombre2 ORDER BY nombre = "COMUN CABINA", nombre',array(':status'=>'1', ':nombre'=>'ZPRUEBA', ':nombre2'=>'COMUN CABINA')), 'Id', 'Nombre');
	}
	public static function getListCabinaResto()
	{
		return CHtml::listData(Cabina::model()->findAll('status=:status AND Nombre!=:nombre ORDER BY nombre = "COMUN CABINA", nombre',array(':status'=>'1', ':nombre'=>'ZPRUEBA')), 'Id', 'Nombre');
	}
        
        public static function getListCabinaForFilterWithoutModel()
	{
		return CHtml::listData(Cabina::model()->findAllBySql("SELECT LPAD(Id+1,2,0) AS 'Id',Nombre FROM Cabina WHERE status=:status AND Nombre!=:nombre ORDER BY nombre = 'COMUN CABINA', nombre;",array(':status'=>'1', ':nombre'=>'ZPRUEBA')), 'Id', 'Nombre');
	}
    
    public static function getNombreCabina($idCabina)
    {
    	$criteria = new CDbCriteria;
    	$criteria->condition = 'Id=:cabina_id';
    	$criteria->params = array(':cabina_id' => $idCabina);
    	$resultSet = Cabina::model()->find($criteria);
    	if(isset($resultSet))
    	{
    		return $resultSet->Nombre;
    	}
    	else
    	{
    		switch(Yii::app()->user->id)
    		{
    			case 2:
    			    return 'gerente';
    			    break;
                case 3:
                    return 'administrador';
                    break;
                case 4:
                    echo "tesorero";
                    break;
                case 5:
                    echo "socio";
                    break;
            }
        }
    }
    public static function getNombreCabina2($idCabina)
    {
    	$criteria = new CDbCriteria;
    	$criteria->condition = 'Id=:cabina_id';
    	$criteria->params = array(':cabina_id' => $idCabina);
    	$resultSet = Cabina::model()->find($criteria);
    	if(isset($resultSet))
    	{
    		return $resultSet->Nombre;
    	}
    	else
    	{
            return 'error buscando cabina';
        }
    }
    
    public static function getNombreCabina3($idCabina)
    {
    	$criteria = new CDbCriteria;
    	$criteria->condition = 'Id=:cabina_id';
    	$criteria->params = array(':cabina_id' => $idCabina);
    	$resultSet = Cabina::model()->find($criteria);
    	if(isset($resultSet))
    	{
    		return $resultSet->Nombre;
    	}
    	else
    	{
            return '';
        }
    }
    /**
    * Encargada de retornar el id de la cabina consultada
    * @param string $cabina.
    * @return int $id.
    */
    public static function getId($cabina)
    {
    	$model=self::model()->find('Nombre=:cabina',array(':cabina'=>$cabina));
    	if($model->Id)
    		return $model->Id;
    	else
    		return false;
    }
}