<?php

/**
 * This is the model class for table "employee".
 *
 * The followings are the available columns in table 'employee':
 * @property integer $id
 * @property string $code_employee
 * @property string $name
 * @property string $lastname
 * @property string $identification_number
 * @property integer $gender
 * @property string $photo_path
 * @property string $address
 * @property integer $immediate_supervisor
 * @property string $phone_number
 * @property double $salary
 * @property integer $CABINA_Id
 * @property integer $academic_level_id
 * @property integer $profession_id
 * @property integer $marital_status_id
 * @property integer $employee_hours_id
 * @property integer $position_id
 *
 * The followings are the available model relations:
 * @property Position $position
 * @property AcademicLevel $academicLevel
 * @property Cabina $cABINA
 * @property EmployeeHours $employeeHours
 * @property MaritalStatus $maritalStatus
 * @property Profession $profession
 * @property Employee $immediateSupervisor
 * @property Employee[] $employees
 * @property Kids[] $kids
 */
class Employee extends CActiveRecord
{
	public $marital_status_name;
        public $academic_level_name;
        public $profession_name;
        public $position_name;
        public $employee_hours_start;
        public $employee_hours_end;
        public $age;
        public $kids;
        public $Cargo;
        public $Cabina;
        public $Moneda;





        public function tableName()
	{
		return 'employee';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, lastname, identification_number, admission_date, gender, address, salary, academic_level_id, profession_id, marital_status_id, position_id, CABINA_Id, phone_number', 'required'),
			array('id, gender, immediate_supervisor, CABINA_Id, academic_level_id, profession_id, marital_status_id, position_id, bank_account', 'numerical', 'integerOnly'=>true),
			array('salary', 'numerical'),
                        array('identification_number','unique'),
			array('code_employee', 'length', 'max'=>4),
			array('name, lastname, identification_number, phone_number', 'length', 'max'=>45),
			array('photo_path', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code_employee, name, lastname, identification_number, gender, photo_path, address, immediate_supervisor, phone_number, salary, CABINA_Id, academic_level_id, profession_id, marital_status_id, marital_status_name, position_id, currency_id, bank_account', 'safe', 'on'=>'search'),
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
			'position' => array(self::BELONGS_TO, 'Position', 'position_id'),
			'academicLevel' => array(self::BELONGS_TO, 'AcademicLevel', 'academic_level_id'),
			'cABINA' => array(self::BELONGS_TO, 'Cabina', 'CABINA_Id'),
                        'employeeHours' => array(self::HAS_MANY, 'EmployeeHours', 'employee_id'),
			'maritalStatus' => array(self::BELONGS_TO, 'MaritalStatus', 'marital_status_id'),
			'profession' => array(self::BELONGS_TO, 'Profession', 'profession_id'),
			'immediateSupervisor' => array(self::BELONGS_TO, 'Employee', 'immediate_supervisor'),
			'employees' => array(self::HAS_MANY, 'Employee', 'immediate_supervisor'),
			'kids' => array(self::HAS_MANY, 'Kids', 'employee_id'),
                        'currency' => array(self::BELONGS_TO,'Currency', 'currency_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code_employee' => 'Codigo',
			'name' => 'Nombre',
			'lastname' => 'Apellido',
			'identification_number' => 'Identificacion',
			'gender' => 'Sexo',
			'photo_path' => 'Ruta de Foto',
			'address' => 'Direccion',
			'immediate_supervisor' => 'Supervisor',
			'phone_number' => 'Telefono/Celular',
			'salary' => 'Remuneracion',
			'CABINA_Id' => 'Cabina',
			'academic_level_id' => 'Nivel Academico',
                        'academic_level_name' => 'Nivel Academico',
			'profession_id' => 'Profesion',
                        'profession_name' => 'Profesion',
			'marital_status_id' => 'Estado Civil',
                        'marital_status_name' => 'Estado Civil',
                        'employee_hours_start' => 'Hora Entrada',
                        'employee_hours_end' => 'Hora Salida',
			'position_id' => 'Cargo',
                        'position_name' => 'Cargo',
                        'status' => 'Estatus',
                        'age' => 'Edad del Hijo',
                        'admission_date' => 'Fecha de Ingreso',
                        'currency_id' => 'Moneda',
                        'bank_account' => 'Cuenta Bancaria',
                    
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
		$criteria->compare('code_employee',$this->code_employee,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('identification_number',$this->identification_number,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('photo_path',$this->photo_path,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('immediate_supervisor',$this->immediate_supervisor);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('salary',$this->salary);
		$criteria->compare('CABINA_Id',$this->CABINA_Id);
		$criteria->compare('academic_level_id',$this->academic_level_id);
		$criteria->compare('profession_id',$this->profession_id);
		$criteria->compare('marital_status_id',$this->marital_status_id);
		$criteria->compare('position_id',$this->position_id);
                $criteria->compare('admission_date',$this->admission_date);
                $criteria->compare('record_date',$this->record_date);
                $criteria->compare('currency_id',$this->currency_id);
                $criteria->compare('bank_account',$this->bank_account,true);
                $criteria->join='INNER JOIN cabina ON cabina.Id=t.CABINA_Id INNER JOIN position ON position.id=t.position_id';
                $orden="cabina.Nombre ASC, position.name ASC, status ASC";
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array('defaultOrder'=>$orden),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Employee the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getCodigoEmpleado(){
            
			$model=self::model()->findBySql('SELECT MAX(code_employee) AS code_employee FROM employee');
			if($model->code_employee == null)
			{
                                return '0001';
			}
			else
			{
				//return (+1);
                                return str_pad(((int)$model->code_employee+1),4,"0",STR_PAD_LEFT);
			}
		
        }
        
        public static function getListEmpleyee($cabina)
        {
          return CHtml::listData(Employee::model()->findAllBySql("SELECT id, CONCAT(name, ' ',lastname) as name FROM employee WHERE CABINA_Id=$cabina"), 'id', 'name');	

        }

        public static function getNameEmployee($id){
            
	  $model=self::model()->findBySql("SELECT CONCAT(name,' ',lastname) AS name FROM employee WHERE id = $id");
          return $model->name ;
		
        }
        
        public static function getName($id){

          if($id != null){
              $model=self::model()->findBySql("SELECT CONCAT(name,' ',lastname) AS name FROM employee WHERE id = $id");
              return $model->name;
          }else{
              return 'Sin Supervisor';
          }    
		
        }
        
        public function setImage($status)
        {
            if($status == 1){
                $dir = Yii::app()->request->baseUrl."/themes/mattskitchen/img/diable2.png";
            }else{
                $dir= Yii::app()->request->baseUrl."/themes/mattskitchen/img/diable3.png";
            }
            
            return $dir;
        }
        
        
        
}
