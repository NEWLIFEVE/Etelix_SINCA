<?php

/**
 * This is the model class for table "destination_int".
 *
 * The followings are the available columns in table 'destination_int':
 * @property integer $id
 * @property string $name
 * @property integer $id_geographic_zone
 *
 * The followings are the available model relations:
 * @property GeographicZone $idGeographicZone
 * @property Balance[] $balances
 */
class DestinationInt extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'destination_int';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('id_geographic_zone', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, id_geographic_zone', 'safe', 'on'=>'search'),
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
			'idGeographicZone' => array(self::BELONGS_TO, 'GeographicZone', 'id_geographic_zone'),
			'balances' => array(self::HAS_MANY, 'Balance', 'id_destination_int'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'id_geographic_zone' => 'Id Geographic Zone',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('id_geographic_zone',$this->id_geographic_zone);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->soriDB;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DestinationInt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getListDestination()
	{
		$model = DestinationInt::model()->findAll();
                $list = '';

                $list.= "<datalist id='destino'>";

                foreach ($model as $value) {
                    $list.= "<option value='$value->name'>";
                }

                $list.= "</datalist>";

                return $list;
	}
        
        public static function getId($nombre){
            
		if($nombre != null)
		{
			$model=self::model()->find('name=:nombre',array(':nombre'=>$nombre));
                        if($model != null)
                            return $model->id;
                        else
                            return NULL;
			
		}
        }
        
        public static function getNombre($id){
            
		if($id != null)
		{
			$model=self::model()->find('id=:id',array(':id'=>$id));
			return $model->name;
			
		}
        }
        
        public static function changeByStatus($status,$id,$destino){
            
		if($status == 1)
		{
		   return CHtml::textField("Destino_$id",DestinationInt::getNombre($destino),array("style"=>"width:200px;","list"=>"destino"));	
		}
                else
                {
                    return self::getNombre($destino);
                }
        }
        
}
