<?php


class NominaController extends Controller
{
    
        public $layout = '//layouts/column2';
               	
        public function accessRules()
	{
        /* 1-Operador de Cabina
         * 2-Gerente de Operaciones
         * 3-Administrador
         * 4-Tesorero
         * 5-Socio
         * 7-RRHH
         */                                
		return array(
			array(
				'allow',
				'actions'=>array(
					'adminEmpleado',
					'viewEmpleado',
					),
				'users'=>Users::UsuariosPorTipo(5),
				),
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(
					'index',
					'viewEmpleado',
					'crearEmpleado',
					'update',
					'adminEmpleado',
					'DesactivarEmpleado',
                                        'DynamicEmployee',
                                        'GetCurrency',
                                        'GetSalary',
					),
				'users'=>Users::UsuariosPorTipo(3),
				),
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(
					'index',
					'viewEmpleado',
					'crearEmpleado',
					'update',
					'adminEmpleado',
					'DesactivarEmpleado',
                                        'DynamicEmployee',
                                        'GetCurrency',
                                        'GetSalary',
					),
				'users'=>Users::UsuariosPorTipo(7),
				),
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(
					'index',
					'viewEmpleado',
					'crearEmpleado',
					'update',
					'adminEmpleado',
					'DesactivarEmpleado',
                                        'DynamicEmployee',
                                        'GetCurrency',
                                        'GetSalary',
					),
				'users'=>Users::UsuariosPorTipo(2),
				),
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(
					'index',
					'viewEmpleado',
					'crearEmpleado',
					'update',
					'adminEmpleado',
					'DesactivarEmpleado',
                                        'DynamicEmployee',
                                        'GetCurrency',
                                        'GetSalary',
					),
				'users'=>Users::UsuariosPorTipo(4),
				),
			array(
				'deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
	public function actionIndex()
	{
		$this->render('index');
	}
        
        public function actionViewEmpleado($id) {
            $this->render('viewEmpleado', array(
                'model' => $this->loadModel($id),
            ));
        }
        
        public function actionAdminEmpleado() {
            $model = new Employee('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Employee']))
                $model->attributes = $_GET['Employee'];

            $this->render('adminEmpleado', array(
                'model' => $model,
            ));
        }
        
        public function actionadminEvento() {
            $model = new EmployeeEvent('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['EmployeeEvent']))
                $model->attributes = $_GET['EmployeeEvent'];

            $this->render('adminEvento', array(
                'model' => $model,
            ));
        }
        
        public function actionCrearEmpleado($id=null)
	{
            if($id!=null){
            $model = $this->loadModel($id);
            
            $model_kid = $this->loadModelKids($id);
                
            $model_hour_day_1 = $this->loadModelEmployeeHoursDay($id,1); 
            $model_hour_day_2= $this->loadModelEmployeeHoursDay($id,2); 
            $model_hour_day_3= $this->loadModelEmployeeHoursDay($id,3); 
            
            }else{
            
            $model=new Employee;
            $model_kid=new Kids;
            $model_hour_day_1 = new EmployeeHours;
            $model_hour_day_2= new EmployeeHours; 
            $model_hour_day_3= new EmployeeHours;
            
            }

             $this->performAjaxValidation(array($model,$model_kid,$model_hour_day_1,$model_hour_day_2,$model_hour_day_3));
            
            if (isset($_POST['Employee'])) {
                
                $model->attributes = $_POST['Employee'];
                $model_hour_day_1->attributes = $_POST['EmployeeHours'];
                $model_hour_day_3->attributes = $_POST['EmployeeHours'];
                $model_hour_day_1->attributes = $_POST['EmployeeHours'];
     
                if($id==null)
                    $model->code_employee = Employee::getCodigoEmpleado();
                 
                
                if(isset($_POST['Employee']['marital_status_name']) && $_POST['Employee']['marital_status_name']!= "")
                    $model->marital_status_id = MaritalStatus::getId($_POST['Employee']['marital_status_name']);
                 else
                    $model->marital_status_id = $_POST['Employee']['marital_status_id'];
                 
                
                if(isset($_POST['Employee']['academic_level_name']) && $_POST['Employee']['academic_level_name']!= "")
                    $model->academic_level_id = AcademicLevel::getId($_POST['Employee']['academic_level_name']);
                else
                    $model->academic_level_id = $_POST['Employee']['academic_level_id'];
                
                
                if(isset($_POST['Employee']['profession_name']) && $_POST['Employee']['profession_name']!= "")
                    $model->profession_id = Profession::getId($_POST['Employee']['profession_name']);
                 else
                    $model->profession_id = $_POST['Employee']['profession_id'];
                 
                
                if(isset($_POST['Employee']['position_name']) && $_POST['Employee']['position_name']!= "")
                    $model->position_id = Position::getId($_POST['Employee']['position_name']);
                 else
                    $model->position_id = $_POST['Employee']['position_id'];
                 

                
                if(isset($_POST['Employee']['status']) && $_POST['Employee']['status']!= "")
                    $model->status = $_POST['Employee']['status'];
                 
                
                if(isset($_POST['Employee']['admission_date']) && $_POST['Employee']['admission_date']!= "")
                    $model->admission_date = Yii::app()->format->formatDate($_POST['Employee']['admission_date'],'post');
                 
                    $model->record_date = date("Y-m-d");
                    $model->currency_id = $_POST['Employee']['currency_id'];

                    if ($model->save()){

                        if($id == false){
                            $id = $model->id;
                        }

                        $this->saveEmployeeHours($id,$_POST['EmployeeHours']);
                        $this->setKids($id,$_POST['Employee']['kids']);

                        Yii::app()->user->setFlash('success',"Datos Guardados Correctamente!");
                        $this->redirect(array('viewEmpleado', 'id' => $model->id));

                    }
                

            }
        
        $this->render('CrearEmpleado',
                array(
                    'model'=>$model,
                    'model_kid'=>$model_kid,
                    'model_hour_day_1'=>$model_hour_day_1,
                    'model_hour_day_2'=>$model_hour_day_2,
                    'model_hour_day_3'=>$model_hour_day_3
                ));
        
	}
        
        public function actionDeleteEmpleado($id) {
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('adminEmpleado'));
        }
        
        
        
        public function actionDesactivarEmpleado($id) {
            
            $model = Employee::model()->findByPk($id);
            $model->status = 2;
            $model->update();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('adminEmpleado'));
        }
        
        
        protected function performAjaxValidation($model) {
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'CrearEmpleado-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        }
        
        public function loadModel($id) {
            $model = Employee::model()->findBySql("SELECT *, DATE_FORMAT(admission_date,'%d/%m/%Y') as admission_date FROM employee WHERE id = $id");
            if ($model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            return $model;
        }
        
        public function loadModelEvent($employee,$event) {
            $model = EmployeeEvent::model()->findBySql("SELECT * FROM employee_event WHERE employee_id = $employee AND event_id = $event");
            if ($model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            return $model;
        }
        
        public function loadModelKids($id) {
            $model_kid = Kids::model()->findAllBySql("SELECT age FROM kids WHERE employee_id = $id ORDER BY age DESC");
            if(count($model_kid) <2){
            $model_kid = Kids::model()->findBySql("SELECT age FROM kids WHERE employee_id = $id ORDER BY age DESC");
                if($model_kid == null){
                    $model_kid= new Kids;
                }
            }
            return $model_kid;
        }
        
        public function saveKids($id,$age) {

            $model_kids = new Kids;
            $model_kids->age = $age;
            $model_kids->employee_id = $id;
            $model_kids->save(false);

        }
        
        public function saveEmployeeHours($id,$day) {
            //var_dump($day);
            for($i=1;$i<4;$i++){
                if($day['day_'.$i] == 1){
                    
                    $model_hour_day = "model_hour_day_".$i;
                    $$model_hour_day = $this->loadModelEmployeeHoursDay($id,$i);
                    $$model_hour_day->start_time = Utility::ChangeTime($day['start_time_'.$i]);
                    $$model_hour_day->end_time = Utility::ChangeTime($day['end_time_'.$i]);
                    $$model_hour_day->employee_id = $id;
                    $$model_hour_day->day = $i;
                    if($$model_hour_day->isNewRecord)
                      $$model_hour_day->save(false);  
                    else
                      $$model_hour_day->updateByPk($$model_hour_day->id,array('start_time'=>Utility::ChangeTime($day['start_time_'.$i]),'end_time'=>Utility::ChangeTime($day['end_time_'.$i])));    
                }else{
                    $this->deleteEmployeeHours($id,$i);
                }
            }

        }
        
        public function setKids($id,$age) {

            $array_age = explode(",", $age);
            $this->deleteKids($id);

            if(!empty($array_age) && $array_age[0]!=''){
            for($i =0;$i<count($array_age);$i++){
            $this->saveKids($id,$array_age[$i]);
            }
            }
        }
        
        public function deleteKids($id) {
            if($id !=null){
            $model = Kids::model()->findAllBySql("SELECT * FROM kids WHERE employee_id = $id");
            foreach ($model as $key => $value) {
                
                   $value->delete(); 
                }
                
            }
        }
        
        public function deleteEmployeeHours($Employee_id,$day) {
            if($Employee_id !=null && $day !=null){
            $model = EmployeeHours::model()->findBySql("SELECT * FROM employee_hours WHERE employee_id = $Employee_id AND day = $day");
            if ($model != null) {
                
                   $model->delete(); 
                }
                
            }
        }
        
        public function loadModelEmployeeHoursDay($id,$day) {
            $model_h = EmployeeHours::model()->findBySql("SELECT id, employee_id, DATE_FORMAT(start_time,'%h:%i %p') as start_time_$day, DATE_FORMAT(end_time,'%h:%i %p') as end_time_$day,  CASE day WHEN $day THEN 1 END as day_$day FROM employee_hours WHERE employee_id = $id AND day = $day");
            if($model_h == null)
                 $model_h = new EmployeeHours;
            return $model_h;
        }
        
        public static function controlAcceso($tipoUsuario)
        {

            /* ADMINISTRADOR */
            if($tipoUsuario == 3)
            {
                return array(
                    array('label' => 'Administrar Empleados', 'url' => array('adminEmpleado')),
                    array('label' => 'Crear Empleado', 'url' => array('CrearEmpleado')),
                    
//                    array('label' => 'Administrar Evento', 'url' => array('adminEvento')),
//                    array('label' => 'Registrar Evento', 'url' => array('EventoEmpleado')),

                );
            }
            /* SOCIO */
            if($tipoUsuario == 5)
            {
                return array(
                    array('label' => 'Administrar Empleados', 'url' => array('adminEmpleado')),
//                    array('label' => 'Crear Empleado', 'url' => array('CrearEmpleado')),
//                    array('label' => 'Administrar Evento', 'url' => array('adminEvento')),
//                    array('label' => 'Registrar Evento', 'url' => array('EventoEmpleado')),

                );
            }
            /* RRHH */
            if($tipoUsuario == 7)
            {
                return array(
                    array('label' => 'Administrar Empleados', 'url' => array('adminEmpleado')),
                    array('label' => 'Crear Empleado', 'url' => array('CrearEmpleado')),
//                    array('label' => 'Administrar Evento', 'url' => array('adminEvento')),
//                    array('label' => 'Registrar Evento', 'url' => array('EventoEmpleado')),

                );
            }
            
        }

	// Uncomment the following methods and override them if needed
	
	public function filters() {
            return array(
                'accessControl', // perform access control for CRUD operations
                'postOnly + delete', // we only allow deletion via POST request
            );
        }
        /*
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/  
        
        public function actionGetSalary()
        {
            $dato = null;
            $sql = "SELECT salary FROM employee WHERE id = ".$_GET['id'];
            $model = Employee::model()->findBySql($sql);
            echo $model->salary;
        }
        
        public function actionGetCurrency()
        {
            $dato = null;
            $sql = "SELECT currency_id FROM employee WHERE id = ".$_GET['id'];
            $model = Employee::model()->findBySql($sql);
            echo $model->currency_id;
        }
        
        public function actionDynamicEmployee()
        {
            $dato = '<option value="empty">Seleccione uno</option>';
            $data = Employee::getListEmpleyee($_GET['cabina']);
            foreach($data as $value=>$name)
            {
                $dato.= "<option value='$value'>".CHtml::encode($name)."</option>";
            }
            echo $dato;
        }
        
        
        
        
}