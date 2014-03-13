<?php

/**
 * This is the model class for table "employee_hours".
 *
 * The followings are the available columns in table 'employee_hours':
 * @property integer $id
 * @property string $start_time
 * @property string $end_time
 *
 * The followings are the available model relations:
 * @property Employee[] $employees
 */
class EmployeeHours extends CActiveRecord
{
	public $day_1;
        public $start_time_1;
        public $end_time_1;
        
        public $day_2;
        public $start_time_2;
        public $end_time_2;
        
        public $day_3;
        public $start_time_3;
        public $end_time_3;
        
	public function tableName()
	{
		return 'employee_hours';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('start_time, end_time,employee_id,day', 'required'),
			array('id,employee_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, start_time, end_time, employee_id,day', 'safe', 'on'=>'search'),
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
			'employees' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'start_time' => 'Hora de Entrada',
			'end_time' => 'Hora de Salida',
                        'employee_id' => 'Empleado',
                        'day' => 'Horario',
                        'employee_hours_start' => 'Hora de Entrada',
                        'employee_hours_end' => 'Hora de Salida',
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
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
                $criteria->compare('employee_id',$this->employee_id);
                $criteria->compare('day',$this->day);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmployeeHours the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getId($start_time,$end_time){
            
		if($start_time != null && $end_time != null)
		{
			$model=self::model()->find('start_time=:start_time AND end_time=:end_time',array(':start_time'=>$start_time,':end_time'=>$end_time));
			if($model == null)
			{
				$model=new EmployeeHours;
				$model->start_time=$start_time;
                                $model->end_time=$end_time;
				if($model->save())
				{
					return $model->id;
				}
			}
			else
			{
				return $model->id;
			}
		}
        }
        
        public static function getEmployeeHoursDay1($id){
            
	  $model=self::model()->findBySql("SELECT CONCAT(DATE_FORMAT(start_time,'%h:%i %p'), ' - ', DATE_FORMAT(end_time,'%h:%i %p')) AS day FROM employee_hours WHERE employee_id = $id AND day = 1");
            if($model == null){
                return $model = 'No Asignado';
            }else{       
                return $model->day ;
            }	
        }
        
        public static function getEmployeeHoursDay2($id){
            
	  $model=self::model()->findBySql("SELECT CONCAT(DATE_FORMAT(start_time,'%h:%i %p'), ' - ', DATE_FORMAT(end_time,'%h:%i %p')) AS day FROM employee_hours WHERE employee_id = $id AND day = 2");
          if($model == null){
                return $model = 'No Asignado';
            }else{        
                return $model->day ;
            }	
		
        }
        
        public static function getEmployeeHoursDay3($id){
            
	  $model=self::model()->findBySql("SELECT CONCAT(DATE_FORMAT(start_time,'%h:%i %p'), ' - ', DATE_FORMAT(end_time,'%h:%i %p')) AS day FROM employee_hours WHERE employee_id = $id AND day = 3");
          if($model == null){
                return $model = 'No Asignado';
            }else{        
                return $model->day ;
            }	
		
        }
}
