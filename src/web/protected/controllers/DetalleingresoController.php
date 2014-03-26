<?php

class DetalleingresoController extends Controller
{
        public $layout = '//layouts/column2';
        
	// Uncomment the following methods and override them if needed
	
	public function filters()
        {
            return array(
                'accessControl', // perform access control for CRUD operations
                'postOnly + delete', // we only allow deletion via POST request
            );
        }

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
        
        public function actionViewIngreso($id)
        {
            $this->render('viewIngreso', array(
                'model'=>$this->loadModel($id),
            ));
        }
        
        public function actionAdminIngreso()
        {
            $model=new Detalleingreso('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Detalleingreso']))
                $model->attributes = $_GET['Detalleingreso'];

            $this->render('adminIngreso', array(
                'model' => $model,
            ));
        }
        
        public function actionCreateIngreso() {
            $model = new Detalleingreso;
            $model_cabina = new Cabina;


            $this->performAjaxValidation($model);

            if(isset($_POST['Detalleingreso']))
            {
                $model->attributes = $_POST['Detalleingreso'];
                $model->Monto=Yii::app()->format->truncarDecimal(Utility::ComaPorPunto($_POST['Detalleingreso']['Monto']));
                $model->FechaMes=$_POST['Detalleingreso']['FechaMes']."-01";        
                $model->Descripcion=$_POST['Detalleingreso']['Descripcion'];
                $model->CABINA_Id=$_POST['Detalleingreso']['CABINA_Id'];
                $model->USERS_Id=  Yii::app()->getModule('user')->user()->id;

                if(isset($_POST['Detalleingreso']['nombreTipoDetalle']) && $_POST['Detalleingreso']['nombreTipoDetalle']!= ""){
                    $model->TIPOINGRESO_Id = TipoIngresos::getIdIngreso($_POST['Detalleingreso']['nombreTipoDetalle']);
                }else{
                    $model->TIPOINGRESO_Id=$_POST['Detalleingreso']['TIPOINGRESO_Id'];
                }

                if(isset($_POST['Detalleingreso']['FechaTransf']) && $_POST['Detalleingreso']['FechaTransf']!= "" )
                {
                    $model->FechaTransf=Yii::app()->format->formatDate($_POST['Detalleingreso']['FechaTransf'],'post');
                }else{
                    $model->FechaTransf=NULL;
                }


                $model->moneda=$_POST['Detalleingreso']['moneda'];
                $model->CUENTA_Id=$_POST['Detalleingreso']['CUENTA_Id'];

                if($model->save())
                    $this->redirect(array('viewIngreso', 'id' => $model->Id));
            }

            $this->render('createIngreso', array(
                'model'=>$model,
                'model_cabina'=>$model_cabina,
            ));
        }
	
        protected function performAjaxValidation($model)
        {
            if(isset($_POST['ajax']) && $_POST['ajax'] === 'declareIngreso-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        }
        
        public function loadModel($id) {
            $model = Detalleingreso::model()->findBySql("SELECT detalleingreso.* FROM detalleingreso WHERE detalleingreso.Id = $id");

            if ($model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            return $model;
        }
        
        public static function controlAcceso($tipoUsuario)
        {
            /* OPERADOR DE CABINA */
            if($tipoUsuario==1)
            {
                return array(
                    //array('label' => 'Declarar Inicio Jornada', 'url' => array('log/createInicioJornada')),
                );
            }
            /* GERENTE DE OPERACIONES */
            if($tipoUsuario==2)
            {
                return array(
                    array('label' => 'Declarar Gasto', 'url' => array('detallegasto/create')),
                   // array('label' => 'Administrar Gastos', 'url' => array('detallegasto/admin')),
                    array('label' => 'Estado de Gastos', 'url' => array('detallegasto/estadoGastos')),
                    array('label' => 'Matriz de Gastos', 'url' => array('detallegasto/matrizGastos')),
                    //array('label' => 'Matriz de Gastos Evolucion', 'url' => array('detallegasto/MatrizGastosEvolucion')),
                );
            }
            /* ADMINISTRADOR */
            if($tipoUsuario==3)
            {
                return array(
                    array('label'=>'__________INGRESOS___________','url'=>array('')),
                    array('label' => 'Declarar Ingreso', 'url' => array('detalleingreso/createIngreso')),
                    array('label' => 'Administrar Ingresos', 'url' => array('detalleingreso/adminIngreso')),
                    array('label'=>'__________GASTOS___________','url'=>array('')),
                    array('label' => 'Declarar Gasto', 'url' => array('detallegasto/create')),
                  //  array('label' => 'Administrar Gastos', 'url' => array('detallegasto/admin')),
                    array('label' => 'Estado de Gastos', 'url' => array('detallegasto/estadoGastos')),
                    array('label' => 'Matriz de Gastos', 'url' => array('detallegasto/matrizGastos')),
                    array('label' => 'Matriz de Gastos Evolucion', 'url' => array('detallegasto/MatrizGastosEvolucion')),
                    array('label' => 'Matriz de Nomina', 'url' => array('detallegasto/matrizNomina')),
                );
            }
            /* TESORERO */
            if($tipoUsuario==4)
            {
                return array(
                    array('label' => 'Administrar Gastos', 'url' => array('detallegasto/admin')),
                );
            }
            /* SOCIO */
            if($tipoUsuario==5)
            {
                return array(
                    array('label' => 'Administrar Gastos', 'url' => array('detallegasto/admin')),
                );
            }
            /* SOCIO */
            if($tipoUsuario==6)
            {
                return array(
                    array('label' => 'Estado de Gastos', 'url' => array('detallegasto/estadoGastos')),
                );
            }
        }
}