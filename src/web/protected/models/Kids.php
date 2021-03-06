<?php

/**
 * This is the model class for table "kids".
 *
 * The followings are the available columns in table 'kids':
 * @property integer $id
 * @property integer $age
 * @property integer $employee_id
 *
 * The followings are the available model relations:
 * @property Employee $employee
 */
class Kids extends CActiveRecord
{
        
                
	public function tableName()
	{
		return 'kids';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id,employee_id', 'required'),
			array('id, age, employee_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, age, employee_id', 'safe', 'on'=>'search'),
                        array('age', 'length', 'min'=>1, 'max'=>100),
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
			'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'age' => 'Edad del Hijo # 1',
			'employee_id' => 'Empleado',
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
		$criteria->compare('age',$this->age);
		$criteria->compare('employee_id',$this->employee_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Kids the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getEmployeeKids($id){
            
	  $model_kid = self::model()->findAllBySql("SELECT age FROM kids WHERE employee_id = $id ORDER BY age DESC");
            if(count($model_kid) <2){
            $model_kid = self::model()->findBySql("SELECT age FROM kids WHERE employee_id = $id ORDER BY age DESC");
                if($model_kid == null){
                    $model_kid= new Kids;
                }
            }
           return $model_kid;	
		
        }
        
        public static function getEmployeeKidsRow($id){
            
          $kids = Array();  
	  $model_kid = self::model()->findAllBySql("SELECT age FROM kids WHERE employee_id = $id ORDER BY age DESC");
          foreach ($model_kid as $key => $value) {
              $kids[$key] = $value->age;
          }
          if(!isset($kids[0]))
            $kids_string = 'No Posee Hijos';
          else
            $kids_string = implode(",", $kids);  
          
          return $kids_string;	
		
        }
}
