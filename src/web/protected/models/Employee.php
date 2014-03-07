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
			array('name, lastname, identification_number, gender, address, salary, academic_level_id, profession_id, marital_status_id, employee_hours_id, position_id, CABINA_Id,', 'required'),
			array('id, gender, immediate_supervisor, CABINA_Id, academic_level_id, profession_id, marital_status_id, employee_hours_id, position_id', 'numerical', 'integerOnly'=>true),
			array('salary', 'numerical'),
			array('code_employee', 'length', 'max'=>4),
			array('name, lastname, identification_number, phone_number', 'length', 'max'=>45),
			array('photo_path', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code_employee, name, lastname, identification_number, gender, photo_path, address, immediate_supervisor, phone_number, salary, CABINA_Id, academic_level_id, profession_id, marital_status_id, marital_status_name, employee_hours_id, position_id', 'safe', 'on'=>'search'),
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
			'employeeHours' => array(self::BELONGS_TO, 'EmployeeHours', 'employee_hours_id'),
			'maritalStatus' => array(self::BELONGS_TO, 'MaritalStatus', 'marital_status_id'),
			'profession' => array(self::BELONGS_TO, 'Profession', 'profession_id'),
			'immediateSupervisor' => array(self::BELONGS_TO, 'Employee', 'immediate_supervisor'),
			'employees' => array(self::HAS_MANY, 'Employee', 'immediate_supervisor'),
			'kids' => array(self::HAS_MANY, 'Kids', 'employee_id'),
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
			'immediate_supervisor' => 'Supervisor Inmediato',
			'phone_number' => 'Telefono',
			'salary' => 'Salario',
			'CABINA_Id' => 'Cabina',
			'academic_level_id' => 'Nivel Academico',
                        'academic_level_name' => 'Nivel Academico',
			'profession_id' => 'Profesion',
                        'profession_name' => 'Profesion',
			'marital_status_id' => 'Estado Civil',
                        'marital_status_name' => 'Estado Civil',
			'employee_hours_id' => 'Horario',
                        'employee_hours_start' => 'Hora Entrada',
                        'employee_hours_end' => 'Hora Salida',
			'position_id' => 'Cargo',
                        'position_name' => 'Cargo',
                        'status' => 'Estatus',
                        'age' => 'Hijo - Edad',
                    
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
		$criteria->compare('employee_hours_id',$this->employee_hours_id);
		$criteria->compare('position_id',$this->position_id);
                
                $orden="code_employee ASC";
                
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
        
}
