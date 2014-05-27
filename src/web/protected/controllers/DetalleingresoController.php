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

	public function accessRules()
    {
        /* 1-Operador de Cabina
         * 2-Gerente de Operaciones
         * 3-Administrador
         * 4-Tesorero
         * 5-Socio
         */
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions'=>array(
                    'index',
                    'viewIngreso',
                    'createIngreso',
                    'adminIngreso',
                    'MatrizIngresos',
                    'DynamicTipoIngreso',
                    'DynamicBalanceAnterios',
                    'DynamicIngresosRegistrado',
                    'CreateTraficoCaptura',
                    'DynamicTraficoCaptura'
                ),
                'users'=>Users::UsuariosPorTipo(3),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions'=>array(
                    'index',
                    'viewIngreso',
                    'createIngreso',
                    'adminIngreso',
                    'MatrizIngresos',
                    'DynamicTipoIngreso',
                    'DynamicBalanceAnterios',
                    'DynamicIngresosRegistrado',
                ),
                'users'=>Users::UsuariosPorTipo(1),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions'=>array(
                    'index',
                    'viewIngreso',
                    'adminIngreso',
                    'MatrizIngresos',
                ),
                'users'=>Users::UsuariosPorTipo(5),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions'=>array(
                    'index',
                    'viewIngreso',
                    'adminIngreso',
                    'MatrizIngresos',
                ),
                'users'=>Users::UsuariosPorTipo(6),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions'=>array(
                    'index',
                    'viewIngreso',
                    'createIngreso',
                    'adminIngreso',
                    'MatrizIngresos',
                    'DynamicTipoIngreso',
                    'DynamicBalanceAnterios',
                    'DynamicIngresosRegistrado',
                    'CreateTraficoCaptura'
                ),
                'users'=>Users::UsuariosPorTipo(2),
            ),
            array('deny', // deny all users
                'users'=>array('*'),
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
        
        public function actionMatrizIngresos()
        {
            if(isset($_POST['formFecha']))
            {
                $this->render('matrizIngresos', array('formFecha'=>$_POST['formFecha']));
            }
            else
            {
               $this->render('matrizIngresos', array()); 
            }
        }
        
        public function actionCreateIngreso($id=null) {
            if($id==null){
                $model = new Detalleingreso;
            }else{
                $model = $this->loadModel($id);
            }
            
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
                    $model->FechaTransf=$_POST['Detalleingreso']['FechaTransf'];
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
            ));
        }
        
        public function actionCreateTraficoCaptura() {

            $arrayCarriers = Array();
            $arrayCa = Array();
            
            if($_POST['Detalleingreso']['FechaMes']){
                
                $list = explode('/', $_POST['Detalleingreso']['FechaMes']);
                $fecha = $list[2]."-".$list[1]."-".$list[0];
                $i = 0;
                $paridad = Paridad::getParidad($fecha);
                $cabinasActivas = Cabina::model()->findAll('Id != 18 AND Id != 19 AND status = 1');

                $logSori = LogSori::getLogSori($fecha);
                if(count($logSori) > 1){
                
                    foreach ($cabinasActivas as $key => $cabinas) {

                        $cabinaId = Cabina::getId($cabinas->Nombre);
                        
                        if($cabinas->Nombre != 'ETELIX - PERU'){
                            $cabinasSori = Carrier::model()->findAllBySql("SELECT id FROM carrier WHERE name LIKE '%$cabinas->Nombre%';");
                        }else{
                            $cabinasSori = Carrier::model()->findAllBySql("SELECT id FROM carrier WHERE name LIKE '%ETELIX.COM%';");
                        }
                        
                        foreach ($cabinasSori as $key2 => $value) {
                            $arrayCa[$key][$key2] = $value->id;
                            $arrayCarriers[$key] = implode(',', $arrayCa[$key]);
                        }
                        
                        $montoSoriCaptura = BalanceSori::getTraficoCaptura($fecha,$arrayCarriers[$key]);
                        $verificaIngreso = Detalleingreso::model()->find("FechaMes = '$fecha' AND CABINA_Id = $cabinaId AND TIPOINGRESO_Id = 15");
                        
                        if($verificaIngreso == NULL && $montoSoriCaptura != 0){
                            $modelIngreso = new Detalleingreso;
                            $modelIngreso->Monto = $montoSoriCaptura;
                            $modelIngreso->FechaMes = $fecha;        
                            $modelIngreso->CABINA_Id = $cabinaId;
                            $modelIngreso->USERS_Id=  58;
                            $modelIngreso->TIPOINGRESO_Id = 15;
                            $modelIngreso->moneda = 1;
                            if($cabinaId == 17){
                                $modelIngreso->CUENTA_Id = 2; 
                            }else{
                                $modelIngreso->CUENTA_Id = 4; 
                            }    
                            
                            if($modelIngreso->save()){ 
                                $i++; 
                                
                                $ventasTrafico = Detalleingreso::getLibroVentas("LibroVentas","trafico", $fecha,$cabinaId);
                                
                                $modeCicloIngreso = CicloIngresoModelo::model()->find("Fecha = '$fecha' AND CABINA_Id = $cabinaId");
                                if($modeCicloIngreso != NULL){
                                    $modeCicloIngreso->DiferencialCaptura = round(($ventasTrafico-$montoSoriCaptura*$paridad)/$paridad,2);
                                    $modeCicloIngreso->AcumuladoCaptura = Detalleingreso::getAcumulado($fecha,$cabinaId);
                                    $modeCicloIngreso->save();
                                }
                                
                                
                            }
                        }    

                    }
                }else{
                    $i = -1;
                }

                if($i > 0){
                    Yii::app()->user->setFlash('success',"Trafico de Captura (USD$) - Datos Guardados Satisfactoriamente");
                }elseif($i == 0){
                    Yii::app()->user->setFlash('error',"Trafico de Captura (USD$) - Ya Existen Datos para la Fecha Seleccionada");
                }elseif($i < 0){
                    Yii::app()->user->setFlash('error',"Trafico de Captura (USD$) - No se ha Cargado los Archivos Definitivos de las Rutas Internal y External para la Fecha Seleccionada");
                }
            }
            $this->redirect('/balance/uploadFullCarga');
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
        
        public function actionDynamicTipoIngreso()
        {
            $arrayTipoIn = Array();
            $compania = Compania::getId($_GET['compania']);
            $data = TipoIngresos::model()->findAllBySql("SELECT Nombre FROM tipo_ingresos WHERE COMPANIA_Id = $compania;");
            
            foreach ($data as $key => $value) {
                $arrayTipoIn[$key] = $value->Nombre;
            }
            
            echo json_encode($arrayTipoIn);
        }
        
        public function actionDynamicTraficoCaptura()
        {
            $arrayRutaIE = Array();
            $list = explode('/', $_GET['fecha']);
            $fecha = $list[2]."-".$list[1]."-".$list[0];
            $vista = $_GET['vista'];
            
            $data = LogSori::getLogSori($fecha);
            
            foreach ($data as $key => $value) {
                $arrayRutaIE[$key] = $value->id_log_action;
            }
            
            echo json_encode($arrayRutaIE);
        }
        
        public function actionDynamicIngresosRegistrado()
        {
            $dataIn = NULL;
            $arrayTipoIngreso = Array();
            $list=explode('/', $_GET['fechaBalance']);
            $fecha = $list[2]."-".$list[1]."-".$list[0];
            $cabina = Yii::app()->getModule('user')->user()->CABINA_Id; 
            $dataIn = TipoIngresos::model()->findAllBySql("SELECT t.Nombre
                                                            FROM detalleingreso as d
                                                            INNER JOIN tipo_ingresos as t ON t.Id = d.TIPOINGRESO_Id
                                                            WHERE d.FechaMes = '$fecha' 
                                                            AND d.CABINA_Id = $cabina 
                                                            ORDER BY d.TIPOINGRESO_Id; ");
            
            foreach ($dataIn as $key => $value) {
                $arrayTipoIngreso[$key] = $value->Nombre;
            }
            
            echo json_encode($arrayTipoIngreso);
        }
        
        public function actionDynamicBalanceAnterios()
        {
            $data = NULL;
            $etapaBalance=$_GET['vista'];
            $list=explode('/', $_GET['fecha']);
            $fecha = $list[2]."-".$list[1]."-".$list[0];
            $cabina = Yii::app()->getModule('user')->user()->CABINA_Id; 
            
            
            if($etapaBalance == 'Ventas'){
                $data = SaldoCabina::model()->findBySql("SELECT Id FROM saldo_cabina WHERE Fecha = '$fecha' AND CABINA_Id = $cabina;");
            }
            if($etapaBalance == 'SaldoApertura'){
                $data = SaldoCabina::model()->findBySql("SELECT Id FROM saldo_cabina WHERE Fecha = '$fecha' AND CABINA_Id = $cabina;");
                if($data != NULL) {
                    $data = NULL; 
                }else{
                    $data = 'true';
                }
            }
            if($etapaBalance == 'SaldoCierre'){
                $data = SaldoCabina::model()->findBySql("SELECT * FROM saldo_cabina WHERE Fecha = '$fecha' AND CABINA_Id = $cabina;");   
                if($data != NULL) {
                    if($data->SaldoCierre != NULL) {
                        $data = NULL; 
                    }else{
                        $data = 'true';
                    }
                }else{
                    $data = 'EmptyBalance';
                }
            }
            if($etapaBalance == 'Deposito'){
                $data = SaldoCabina::model()->findBySql("SELECT * FROM saldo_cabina WHERE Fecha = '$fecha' AND CABINA_Id = $cabina;");   
                if($data != NULL) {
                    $data2 = Deposito::model()->findBySql("SELECT * FROM deposito WHERE FechaCorrespondiente = '$fecha' AND CABINA_Id = $cabina;");
                    if($data2 != NULL) {
                        $data = NULL; 
                    }else{
                        $data = 'true';
                    }
                }else{
                    $data = 'EmptyBalance';
                }
            }
            
            
            if($data != NULL && $data != 'EmptyBalance') {
                echo 'true';
            }elseif($data != NULL && $data == 'EmptyBalance'){
                echo 'EmptyBalance';
            }elseif($data == NULL){
                echo 'false';
            }

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
                 array('label'=>'__________INGRESOS___________','url'=>array('')),
                array('label' => 'Declarar Ingreso', 'url' => array('detalleingreso/createIngreso')),
                array('label' => 'Administrar Ingresos', 'url' => array('detalleingreso/adminIngreso')),
                array('label' => 'Matriz de Ingresos', 'url' => array('detalleingreso/matrizIngresos')),
                array('label'=>'__________GASTOS___________','url'=>array('')),
                array('label' => 'Declarar Gasto', 'url' => array('detallegasto/create')),
              //  array('label' => 'Administrar Gastos', 'url' => array('detallegasto/admin')),
                array('label' => 'Estado de Gastos', 'url' => array('detallegasto/estadoGastos')),
                array('label' => 'Matriz de Gastos', 'url' => array('detallegasto/matrizGastos')),
                array('label' => 'Matriz de Gastos Evolucion', 'url' => array('detallegasto/MatrizGastosEvolucion')),
                array('label' => 'Matriz de Nomina', 'url' => array('detallegasto/matrizNomina')),
            );
        }
        /* ADMINISTRADOR */
        if($tipoUsuario==3)
        {
            return array(
                array('label'=>'__________INGRESOS___________','url'=>array('')),
                array('label' => 'Declarar Ingreso', 'url' => array('detalleingreso/createIngreso')),
                array('label' => 'Administrar Ingresos', 'url' => array('detalleingreso/adminIngreso')),
                array('label' => 'Matriz de Ingresos', 'url' => array('detalleingreso/matrizIngresos')),
                array('label'=>'__________GASTOS___________','url'=>array('')),
                array('label' => 'Declarar Gasto', 'url' => array('detallegasto/create')),
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
                array('label'=>'__________INGRESOS___________','url'=>array('')),
                array('label' => 'Declarar Ingreso', 'url' => array('detalleingreso/createIngreso')),
                array('label' => 'Administrar Ingresos', 'url' => array('detalleingreso/adminIngreso')),
                array('label' => 'Matriz de Ingresos', 'url' => array('detalleingreso/matrizIngresos')),
                array('label'=>'__________GASTOS___________','url'=>array('')),
                array('label' => 'Declarar Gasto', 'url' => array('detallegasto/create')),
                array('label' => 'Estado de Gastos', 'url' => array('detallegasto/estadoGastos')),
                array('label' => 'Matriz de Gastos', 'url' => array('detallegasto/matrizGastos')),
                array('label' => 'Matriz de Gastos Evolucion', 'url' => array('detallegasto/MatrizGastosEvolucion')),
                array('label' => 'Matriz de Nomina', 'url' => array('detallegasto/matrizNomina')),
            );
        }
        /* SOCIO */
        if($tipoUsuario==5)
        {
           return array(
                array('label'=>'__________INGRESOS___________','url'=>array('')),
                array('label' => 'Administrar Ingresos', 'url' => array('detalleingreso/adminIngreso')),
                array('label' => 'Matriz de Ingresos', 'url' => array('detalleingreso/matrizIngresos')),
                array('label'=>'__________GASTOS___________','url'=>array('')),
                array('label' => 'Estado de Gastos', 'url' => array('detallegasto/estadoGastos')),
                array('label' => 'Matriz de Gastos', 'url' => array('detallegasto/matrizGastos')),
                array('label' => 'Matriz de Gastos Evolucion', 'url' => array('detallegasto/MatrizGastosEvolucion')),
                array('label' => 'Matriz de Nomina', 'url' => array('detallegasto/matrizNomina')),
            );
        }
        /* CONTABILIDAD */
        if($tipoUsuario==6)
        {
           return array(
                array('label'=>'__________INGRESOS___________','url'=>array('')),
                array('label' => 'Administrar Ingresos', 'url' => array('detalleingreso/adminIngreso')),
                array('label' => 'Matriz de Ingresos', 'url' => array('detalleingreso/matrizIngresos')),
                array('label'=>'__________GASTOS___________','url'=>array('')),
                array('label' => 'Estado de Gastos', 'url' => array('detallegasto/estadoGastos')),
                array('label' => 'Matriz de Gastos', 'url' => array('detallegasto/matrizGastos')),
                array('label' => 'Matriz de Gastos Evolucion', 'url' => array('detallegasto/MatrizGastosEvolucion')),
                array('label' => 'Matriz de Nomina', 'url' => array('detallegasto/matrizNomina')),
            );
        }
    }
}