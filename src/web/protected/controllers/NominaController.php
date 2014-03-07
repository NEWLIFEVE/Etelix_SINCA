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
        
        public function actionCrearEmpleado($id=null)
	{
            if($id!=null){
            $model = $this->loadModel($id);
            $model_kid = $this->loadModelKids($id);
            }else{
            //var_dump($_POST);
            $model=new Employee;
            $model_kid=new Kids;
            }
            
            //var_dump($_POST);
             $this->performAjaxValidation(array($model,$model_kid));

            if (isset($_POST['Employee'])) {
                
                $model->attributes = $_POST['Employee'];
                $model_kid->attributes = $_POST['Employee'];
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
                
                if((isset($_POST['Employee']['employee_hours_start']) && $_POST['Employee']['employee_hours_start']!= "") && (isset($_POST['Employee']['employee_hours_end']) && $_POST['Employee']['employee_hours_end']!= "")){
                    $model->employee_hours_id = EmployeeHours::getId($_POST['Employee']['employee_hours_start'],$_POST['Employee']['employee_hours_end']);
                }else{
                    $model->employee_hours_id = $_POST['Employee']['employee_hours_id'];
                }

                $model->address = $_POST['Employee']['address'];
                $model->phone_number = $_POST['Employee']['phone_number'];
                $model->CABINA_Id = $_POST['Employee']['CABINA_Id'];
                $model->immediate_supervisor = $_POST['Employee']['immediate_supervisor'];
                $model->salary = $_POST['Employee']['salary'];
                
                if(isset($_POST['Employee']['status']) && $_POST['Employee']['status']!= ""){
                $model->status = $_POST['Employee']['status'];
                }
                
                //if(isset($_POST['Employee']['age']) && $_POST['Employee']['age']!= ""){
                
                //}
                
                
                        
                if ($model->save()){
                    
                    $model_kid->age = $_POST['Employee']['age'];
                    $model_kid->employee_id = $model->id;
                    //var_dump($model->id);
                    if ($model_kid->save(false)){
                        Yii::app()->user->setFlash('success',"Datos Guardados Correctamente!");
                        $this->redirect(array('viewEmpleado', 'id' => $model->id));
                    }
                }

            }
        
        $this->render('CrearEmpleado',array('model'=>$model,'model_kid'=>$model_kid));
        
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
            $model = Employee::model()->findByPk($id);
            if ($model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            return $model;
        }
        
        public function loadModelKids($id) {
            $model = Kids::model()->findBySql("SELECT age FROM kids WHERE employee_id = $id");
            if ($model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            return $model;
        }
        
        public static function controlAcceso($tipoUsuario)
        {

            /* ADMINISTRADOR */
            if($tipoUsuario == 3)
            {
                return array(
                    array('label' => 'Administrar Empleados', 'url' => array('adminEmpleado')),
                    array('label' => 'Crear Empleado', 'url' => array('CrearEmpleado')),

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
        
}