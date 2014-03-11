<?php


class NominaController extends Controller
{
    
        public $layout = '//layouts/column2';
        
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
        
        public function actionEventoEmpleado($employee_id=null,$event_id=null) {
            
            if($employee_id!=null && $event_id!=null){
            $model = $this->loadModelEvent($employee_id,$event_id);
            }else{
            //var_dump($_POST);
            $model=new EmployeeEvent;
            }
            
            $this->performAjaxValidation($model);

            if (isset($_POST['EmployeeEvent'])) {
                
            $model->attributes = $_POST['EmployeeEvent'];
                
            $model->employee_id = $_POST['EmployeeEvent']['employee_id'];
            $model->event_id = $_POST['EmployeeEvent']['event_id'];
            $model->concurrency_date = Yii::app()->format->formatDate($_POST['EmployeeEvent']['concurrency_date'],'post');
            $model->record_date = date("Y-m-d");
            
            if ($model->save()){
                    
                Yii::app()->user->setFlash('success',"Datos Guardados Correctamente!");
                $this->redirect(array('viewEventoEmpleado', array('employee_id' => $model->employee_id,'event_id' => $model->event_id)));
                    
            }
            
            }

            $this->render('EventoEmpleado', array(
                'model' => $model,
            ));
            
           
        }
        
        public function actionCrearEmpleado($id=null)
	{
            if($id!=null){
            $model = $this->loadModel($id);
            $model_kid = $this->loadModelKids($id);
                if($model_kid == null){
                    $model_kid=new Kids;
                }
            $model_hour = $this->loadModelEmployeeHours($id);  
            //var_dump($model_kid);
            }else{
            
            $model=new Employee;
            $model_kid=new Kids;
            $model_hour=new EmployeeHours;
            }
            
             $this->performAjaxValidation(array($model,$model_kid,$model_hour));
            
            if (isset($_POST['Employee'])) {
                //var_dump($_POST);
                $model->attributes = $_POST['Employee'];
//                $model_kid->attributes = $_POST['Kids'];
//                $model_hour->attributes = $_POST['Employee'];
                //$model->id = $_POST['Employee']['id'];
                if($id==null){
                $model->code_employee = Employee::getCodigoEmpleado();
                }
                
                
                $model->name = $_POST['Employee']['name'];
                $model->lastname = $_POST['Employee']['lastname'];
                $model->identification_number = $_POST['Employee']['identification_number'];
                $model->gender = $_POST['Employee']['gender'];
                
                if(isset($_POST['Employee']['marital_status_name']) && $_POST['Employee']['marital_status_name']!= ""){
                    $model->marital_status_id = MaritalStatus::getId($_POST['Employee']['marital_status_name']);
                }else{
                    $model->marital_status_id = $_POST['Employee']['marital_status_id'];
                }
                
                if(isset($_POST['Employee']['academic_level_name']) && $_POST['Employee']['academic_level_name']!= ""){
                    $model->academic_level_id = AcademicLevel::getId($_POST['Employee']['academic_level_name']);
                }else{
                    $model->academic_level_id = $_POST['Employee']['academic_level_id'];
                }
                
                if(isset($_POST['Employee']['profession_name']) && $_POST['Employee']['profession_name']!= ""){
                    $model->profession_id = Profession::getId($_POST['Employee']['profession_name']);
                }else{
                    $model->profession_id = $_POST['Employee']['profession_id'];
                }
                
                if(isset($_POST['Employee']['position_name']) && $_POST['Employee']['position_name']!= ""){
                    $model->position_id = Position::getId($_POST['Employee']['position_name']);
                }else{
                    $model->position_id = $_POST['Employee']['position_id'];
                }
                
//                if((isset($_POST['Employee']['employee_hours_start']) && $_POST['Employee']['employee_hours_start']!= "") && (isset($_POST['Employee']['employee_hours_end']) && $_POST['Employee']['employee_hours_end']!= "")){
//                    $model->employee_hours_id = EmployeeHours::getId($_POST['Employee']['employee_hours_start'],$_POST['Employee']['employee_hours_end']);
//                }else{
//                    $model->employee_hours_id = $_POST['Employee']['employee_hours_id'];
//                }

                $model->address = $_POST['Employee']['address'];
                $model->phone_number = $_POST['Employee']['phone_number'];
                $model->CABINA_Id = $_POST['Employee']['CABINA_Id'];
                $model->immediate_supervisor = $_POST['Employee']['immediate_supervisor'];
                $model->salary = $_POST['Employee']['salary'];
                
                if(isset($_POST['Employee']['status']) && $_POST['Employee']['status']!= ""){
                $model->status = $_POST['Employee']['status'];
                }
                
                $model->admission_date = Yii::app()->format->formatDate($_POST['Employee']['admission_date'],'post');
                $model->record_date = date("Y-m-d");
                
                
                        
                if ($model->save()){
                    $array = explode(",", $_POST['Employee']['kids']);
                    //var_dump($array);
                    $this->deleteKids($id);
                    for($i =0;$i<count($array);$i++){
                    $this->sevaKids($id,$array[$i]);
                    }

//                    if ($model_kid->save(false)){
                        
//                        $model_hour->start_time = $_POST['EmployeeHours']['employee_hours_start'];
//                        $model_hour->end_time = $_POST['EmployeeHours']['employee_hours_end'];
//                        $model_hour->day = $_POST['EmployeeHours']['day'];
//                        $model_hour->employee_id = $model->id;
//                        
//                        if ($model_hour->save(false)){
                        Yii::app()->user->setFlash('success',"Datos Guardados Correctamente!");
                        $this->redirect(array('viewEmpleado', 'id' => $model->id));
////                        }
                    
                }

            }
        
        $this->render('CrearEmpleado',array('model'=>$model,'model_kid'=>$model_kid,'model_hour'=>$model_hour));
        
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
            $model_kid = Kids::model()->findAllBySql("SELECT age FROM kids WHERE employee_id = $id");
            return $model_kid;
        }
        
        public function sevaKids($id,$age) {
            
            $model = Kids::model()->findBySql("SELECT * FROM kids WHERE employee_id = $id AND age = $age");
            if(!$model){
                
            $model_kids = new Kids;
            $model_kids->age = $age;
            $model_kids->employee_id = $id;
            $model_kids->save(false);

            }
            
        }
        
        public function deleteKids($id) {
            $model = Kids::model()->findBySql("SELECT * FROM kids WHERE employee_id = $id");
            if($model)
            $model->delete();
        }
        
        public function loadModelEmployeeHours($id) {
            $model_kid = EmployeeHours::model()->findBySql("SELECT * FROM employee_hours WHERE employee_id = $id");
            return $model_kid;
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