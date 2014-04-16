<?php

/**
 * This is the model class for table "novedad_locutorio".
 *
 * The followings are the available columns in table 'novedad_locutorio':
 * @property integer $id
 * @property integer $NOVEDAD_Id
 * @property integer $LOCUTORIO_Id
 *
 * The followings are the available model relations:
 * @property Novedad $nOVEDAD
 * @property Locutorio $lOCUTORIO
 */
class NovedadLocutorio extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
         public $Puesto;
    
    
	public function tableName()
	{
		return 'novedad_locutorio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('NOVEDAD_Id, LOCUTORIO_Id', 'required'),
			array('NOVEDAD_Id, LOCUTORIO_Id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, NOVEDAD_Id, LOCUTORIO_Id', 'safe', 'on'=>'search'),
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
			'nOVEDAD' => array(self::BELONGS_TO, 'Novedad', 'NOVEDAD_Id'),
			'lOCUTORIO' => array(self::BELONGS_TO, 'Locutorio', 'LOCUTORIO_Id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'NOVEDAD_Id' => 'Novedad',
			'LOCUTORIO_Id' => 'Locutorio',
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
		$criteria->compare('NOVEDAD_Id',$this->NOVEDAD_Id);
		$criteria->compare('LOCUTORIO_Id',$this->LOCUTORIO_Id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NovedadLocutorio the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getLocutorioRow($id)
        {
          $model_novedad = Novedad::model()->findBySql("SELECT Puesto FROM novedad WHERE Id = $id");
          $puesto = $model_novedad->Puesto;
          if($puesto == NULL){
            
            $puestos = Array();  
            $model = self::model()->findAllBySql("SELECT LOCUTORIO_Id FROM novedad_locutorio WHERE NOVEDAD_Id = $id ORDER BY LOCUTORIO_Id ASC");
            foreach ($model as $key => $value) {
                $puestos[$key] = $value->LOCUTORIO_Id;
            }
            if(!isset($puestos[0]))
              $puestos_string = '0';
            elseif(isset($puestos[0]) && $puestos[0] != 11)
              $puestos_string = implode(",", $puestos);  
            elseif($puestos[0] == 11)
              $puestos_string = 'Todas';  

            return $puestos_string;

          }else{
            return $model_novedad->Puesto;  
          }
        }
}
