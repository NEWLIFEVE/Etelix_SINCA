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
                        'DynamicTraficoCaptura',
                        'AdminBalance',
                        'ReporteLibroVentas',
                        'CreateLlamadas',
                        'View',
                        'Viewall',
                        'UploadFullCarga',
                        'GuardarExcelBD',
                        'Upload',
                        'CicloIngresos',
                        'cicloIngresosTotal',
                        'Pop',
                        'ReporteFullCarga',
                        'ReporteCaptura',
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
                        'CreateLlamadas',
                        'AdminBalance',
                    ),
                    'users'=>Users::UsuariosPorTipo(1),
                ),
                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions'=>array(
                        'AdminBalance',
                        'ReporteLibroVentas',
                    ),
                    'users'=>array_merge(Users::UsuariosPorTipo(4)),
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
        
    
        /* ------------------------------- Accciones del Balance ------------------------------- */
    
        public function actionAdminBalance()
        {
            $model=new SaldoCabina('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['SaldoCabina'])) $model->attributes=$_GET['SaldoCabina'];

            $this->render('adminBalance', array(
                'model'=>$model,
            ));
        }
        
        public function actionView($id)
        {
            $this->render('view', array(
                'model'=>$this->loadModel($id),
            ));
        }
        
        public function actionViewall($id)
        {
            $this->render('viewall', array(
                'model'=>$this->loadModel($id),
            ));
        }
        
        public function actionReporteLibroVentas()
        {
            $model=new SaldoCabina('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['SaldoCabina'])) $model->attributes=$_GET['SaldoCabina'];

            $this->render('reporteLibroVentas', array(
                'model'=>$model,
            ));
        }
        
        public function actionCicloIngresos()
        {
            $model=new SaldoCabina('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['SaldoCabina'])) $model->attributes=$_GET['SaldoCabina'];

            $this->render('cicloIngresos', array(
                'model'=>$model,
            ));
        }     

        public function actioncicloIngresosTotal()
        {
            $model=new SaldoCabina('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['SaldoCabina'])) $model->attributes=$_GET['SaldoCabina'];
            $this->render('cicloIngresosTotal', array(
                'model'=>$model,
            ));
        }
        
        public function actionReporteFullCarga()
        {
            $model=new SaldoCabina('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['SaldoCabina'])) $model->attributes = $_GET['SaldoCabina'];

            $this->render('reporteFullCarga', array(
                'model'=>$model,
            ));
        }

        public function actionReporteCaptura()
        {
            $model=new SaldoCabina('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['SaldoCabina'])) $model->attributes=$_GET['SaldoCabina'];

            $this->render('reporteCaptura', array(
                'model'=>$model,
                )
            );
        }
        
        public function actionCreateLlamadas()
        {
            $model=new Detalleingreso;

            $this->performAjaxValidationBalance($model);
            if(isset($_POST['Detalleingreso']))
            {
                $i = 0;
                $cabina = Yii::app()->getModule('user')->user()->CABINA_Id; 

                $list=explode('/', $_POST['Detalleingreso']['FechaMes']);
                $Fecha = $list[2]."-".$list[1]."-".$list[0];

                if(count($_POST['Detalle'])>0){
                    foreach (array_filter($_POST['Detalle']) as $key => $value) {

                        $balanceExistente = Detalleingreso::model()->find('FechaMes=:fecha AND CABINA_Id=:cabina AND TIPOINGRESO_Id=:ingreso',
                                                                    array(':fecha'=>$Fecha,':cabina'=>$cabina,':ingreso'=>TipoIngresos::getIdIngreso($key)));
                        if($balanceExistente==NULL){
                            $model=new Detalleingreso;
                            $model->FechaMes = $Fecha; 
                            $model->Monto = str_replace(',','.',$_POST['Detalle'][$key]); 
                            $model->moneda = 2; 
                            $model->USERS_Id = Yii::app()->getModule('user')->user()->id; 
                            $model->CABINA_Id = $cabina;
                            $model->TIPOINGRESO_Id = TipoIngresos::getIdIngreso($key); 
                            if($cabina == 17){
                                $model->CUENTA_Id = 2;
                            }else{
                                $model->CUENTA_Id = 4;
                            }    

                            $model->save();
                            $i++;
                        }
                    }
                }

                if($i>0){
                    LogController::RegistrarLog(3,$Fecha);
                    $this->redirect(array('adminBalance'));
                }else{
                    Yii::app()->user->setFlash('error', "ERROR: La Fecha Indicada ya Posee los Ingresos Declarados");
                    $this->redirect(array('createLlamadas'));
                }
            }

            $this->render('createLlamadas', array(
                'model'=>$model,
            ));
        }
        
        public function actionUploadFullCarga() {

            $model = new Detalleingreso;
            $usuario = Yii::app()->getModule('user')->user()->username;
            
            if(isset($_POST["UpdateFile"])){

                Yii::import('ext.phpexcelreader.JPhpExcelReader');

                $fileName1='FullCarga.xls';
                $ruta = Yii::getPathOfAlias('webroot.uploads').DIRECTORY_SEPARATOR;
                $ruta1=$ruta.$usuario.DIRECTORY_SEPARATOR.$fileName1;

                if(file_exists($ruta1)){
                    $data1=new JPhpExcelReader($ruta1);
                    $data1->saveDB("FullCarga");
                }elseif(!file_exists($ruta1)){
                    Yii::app()->user->setFlash('error',"ERROR: Debe Seleccionar un Archivo");  
                }
                
                if(isset($_SESSION['cabinas'])){
                    
                    echo 'Cabinas: ';
                    var_dump($_SESSION['cabinas']);
                    echo '<br><br>';
                    echo 'Monto: ';
                    var_dump($_SESSION['monto']);
                    echo '<br><br>';
                    echo 'Fecha: ';
                    echo $_SESSION['fecha'];
                    echo '<br><br>';
                    echo 'Servicios: ';
                    var_dump($_SESSION['servicio']);
  
                    if(file_exists($ruta1)){
                        unlink($ruta1);
                    }
                    
                }
                
            }

            $this->render('uploadFullCarga', array(
                'model'=>$model,
            ));

        }
        
        public function actionGuardarExcelBD()
        {
            Yii::import('ext.phpexcelreader.JPhpExcelReader');
            $fileName1='claro.xls';
            $ruta1=Yii::getPathOfAlias('webroot.uploads').DIRECTORY_SEPARATOR.$fileName1;
            if(file_exists($ruta1))
            {
                $data1=new JPhpExcelReader($ruta1);
                $data1->saveDB("claro");
            }
            $fileName2='captura.xls';
            $fileName2r='captura.XLS';
            $ruta2=Yii::getPathOfAlias('webroot.uploads').DIRECTORY_SEPARATOR.$fileName2;
            $ruta2r=Yii::getPathOfAlias('webroot.uploads').DIRECTORY_SEPARATOR.$fileName2r;
            if(file_exists($ruta2))
            {
                $data2=new JPhpExcelReader($ruta2);
                $data2->saveDB("captura");
            }
            elseif(file_exists($ruta2r))
            {
                $data2=new JPhpExcelReader($ruta2r);
                $data2->saveDB("captura");
            }
            $fileName3='movistar.xls';
            $ruta3=Yii::getPathOfAlias('webroot.uploads').DIRECTORY_SEPARATOR.$fileName3;
            if(file_exists($ruta3))
            {
                $data3=new JPhpExcelReader($ruta3);
                $data3->saveDB("movistar");
            }
            $fileName4='etelixPeru.xls';
            $ruta4=Yii::getPathOfAlias('webroot.uploads').DIRECTORY_SEPARATOR.$fileName4;
            if(file_exists($ruta4))
            {
                $data4=new JPhpExcelReader($ruta4);
                $data4->saveDB("etelixPeru"); 
            }
            if(!file_exists($ruta1) && !file_exists($ruta2) && !file_exists($ruta2r) && !file_exists($ruta3) && !file_exists($ruta4))
            {
                Yii::app()->user->setFlash('error',"No hay archivos subidos al sistema S I N C A.");  
            }
            if($data1!=null || $data2!=null || $data3!=null || $data4!=null)
            {
                Yii::app()->user->setFlash('success',"Se han cargado los Datos con exito");
            }
            $this->redirect('index');
        }

        /**
         * @access public
         */
        public function actionUpload()
        {
            Yii::import("ext.EAjaxUpload.qqFileUploader");

            $usuario = Yii::app()->getModule('user')->user()->username;
            $carpetaUsuario = Yii::getPathOfAlias('webroot.uploads').DIRECTORY_SEPARATOR;

            Users::createFolderUser($carpetaUsuario,$usuario);

            $folder=$carpetaUsuario.$usuario.DIRECTORY_SEPARATOR;// folder for uploaded files
            $allowedExtensions=array("xls","XLS");//array("jpg","jpeg","gif","exe","mov" and etc...
            $sizeLimit=1*1024*1024;// maximum file size in bytes
            $uploader=new qqFileUploader($allowedExtensions, $sizeLimit);
            $result=$uploader->handleUpload($folder);
            $return=htmlspecialchars(json_encode($result), ENT_NOQUOTES);

            $fileSize=filesize($folder . $result['filename']); //GETTING FILE SIZE
            $fileName=$result['filename']; //GETTING FILE NAME

            echo $return; // it's array
        }
        
        public function actionPop($id)
        {
            $model=new SaldoCabina('search');
            $model2=new Deposito('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['SaldoCabina'])) $model->attributes = $_GET['SaldoCabina'];
            switch($id)
            {
                case '1':
                    $this->render('reporteLibroVentas', array(
                        'model'=>$model,'fancybox'=>'true',
                    ));
                    break;
                case '2':
                    $this->render('/deposito/reporteDepositos', array(
                        'model'=>$model,'fancybox'=>'true',
                    ));
                    break;
                case '3':
                    $this->render('reporteFullCarga', array(
                        'model'=>$model,'fancybox'=>'true',
                    ));
                    break;
                case '4':
                    $this->render('reporteCaptura', array(
                        'model'=>$model,'fancybox'=>'true',
                    ));
                    break;
                case '5':
                    $this->render('_disLibroVentas', array(
                        'model'=>$model,
                    ));
                    break;
                case '6':
                    $this->render('_disDepositos', array(
                        'model'=>$model,
                    ));
                    break;
                case '7':
                    $this->render('_disBrightstar', array(
                        'model'=>$model,
                    ));
                    break;
                case '8':
                    $this->render('_disCaptura', array(
                        'model'=>$model,
                    ));
                    break;
            }
        }
        
    
        /* ------------------------------- Acciones Propias de Detalle Ingreso ------------------------------- */
    
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
        
        protected function performAjaxValidationBalance($model)
        {
            if(isset($_POST['ajax']) && $_POST['ajax'] === 'ventas-fullcarga-form')
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
    
    public static function controlAccesoBalance($tipoUsuario)
    {
        //OPERADOR DE CABINA
        if($tipoUsuario==1)
        {
            return array(
                    array('label'=>'Declarar Inicio Jornada','url'=>array('log/createInicioJornada')),
                    array('label'=>'Declarar Saldo Apertura','url'=>array('saldocabina/createApertura')),
                    array('label'=>'Declarar Ventas','url'=>array('detalleingreso/createLlamadas')),
                    array('label'=>'Declarar Deposito','url'=>array('deposito/createDeposito')),
                    array('label'=>'Declarar Saldo Cierre','url'=>array('saldocabina/createCierre')),
                    array('label'=>'Declarar Fin Jornada','url'=>array('log/createFinJornada')),
                    array('label'=>'Mostrar Balances de Cabina','url'=>array('detalleingreso/adminBalance')),
                );
        }
        //GERENTE DE OPERACIONES
        if($tipoUsuario==2)
        {
            return array(
                array('label'=>'Cargar data FullCarga y SORI','url'=>array('balance/uploadFullCarga')),
//                array('label'=>'Ingresar Datos Brightstar','url'=>array('balance/brightstar')),
//                array('label'=>'Ingresar Datos Captura','url'=>array('balance/captura')),
                array('label'=>'__________REPORTES___________','url'=>array('')),
                array('label'=>'Reporte Libro Ventas','url'=>array('balance/reporteLibroVentas')),
                array('label'=>'Reporte Depositos Bancarios','url'=>array('balance/reporteDepositos')),
                array('label'=>'Reporte Brightstar','url'=>array('balance/reporteBrightstar')),
                array('label'=>'Reporte Captura','url'=>array('balance/reporteCaptura')),
                array('label'=>'Reporte Ciclo de Ingresos','url'=>array('balance/cicloIngresos')),
                array('label'=>'Reporte Ciclo de Ingresos Total','url'=>array('balance/cicloIngresosTotal')),
                array('label'=>'_____________________________','url' => array('')),
                array('label'=>'Administrar Balances','url'=>array('balance/admin')),
                array('label'=>'Horarios Cabina','url'=>array('cabina/admin')),
                array('label'=>'Tablero de Control de Actv.','url'=>array('balance/controlPanel')),
                );
        }
        //ADMINISTRADOR 
        if($tipoUsuario==3)
        {
            return array(
                array('label'=>'Tablero de Control de Actv.','url'=>array('log/controlPanel')),
                array('label'=>'Administrar Balances','url'=>array('detalleingreso/adminBalance')),
                array('label'=>'Horarios Cabina','url'=>array('cabina/admin')),
                array('label'=>'__________REPORTES___________','url'=>array('')),
                array('label'=>'Reporte Libro Ventas','url'=>array('detalleingreso/reporteLibroVentas')),
                array('label'=>'Reporte Depositos Bancarios','url'=>array('deposito/reporteDepositos')),
                array('label'=>'Reporte Brightstar','url'=>array('detalleingreso/reporteFullCarga')),
                array('label'=>'Reporte Captura','url'=>array('detalleingreso/reporteCaptura')),
                array('label'=>'Reporte Ciclo de Ingresos','url'=>array('detalleingreso/cicloIngresos')),
                array('label'=>'Reporte Ciclo de Ingresos Total','url'=>array('detalleingreso/cicloIngresosTotal')),
                );
        }
        //TESORERO
        if($tipoUsuario==4)
        {
            return array(
                array('label'=>'Reporte Libro Ventas','url'=>array('detalleingreso/reporteLibroVentas')),
                array('label'=>'Reporte Depositos Bancarios','url'=>array('deposito/reporteDepositos')),
                array('label'=>'Reporte Brightstar','url'=>array('balance/reporteBrightstar')),
                array('label'=>'Reporte Captura','url'=>array('balance/reporteCaptura')),
                array('label'=>'Reporte Ciclo de Ingresos','url'=>array('balance/cicloIngresos')),
                array('label'=>'Reporte Ciclo de Ingresos Total','url'=>array('balance/cicloIngresosTotal')),
                array('label'=>'_____________________________','url'=>array('')),
                array('label'=>'Administrar Balances','url'=>array('detalleingreso/adminBalance')),
                array('label'=>'Tablero de Control de Actv.','url'=>array('log/controlPanel')),
                array('label'=>'Horarios Cabina','url'=>array('cabina/admin')),
                );
        }
        //SOCIO
        if($tipoUsuario==5)
        {
            return array(
                array('label'=>'Tablero de Control de Actv.','url'=>array('balance/controlPanel')),
                array('label'=>'Administrar Balances','url'=>array('balance/admin')),
                array('label'=>'Horarios Cabina','url'=>array('cabina/admin')),
                array('label'=>'__________REPORTES___________','url'=>array('')),
                array('label'=>'Reporte Libro Ventas','url'=>array('balance/reporteLibroVentas')),
                array('label'=>'Reporte Depositos Bancarios','url'=>array('balance/reporteDepositos')),
                array('label'=>'Reporte Brightstar','url'=>array('balance/reporteBrightstar')),
                array('label'=>'Reporte Captura','url'=>array('balance/reporteCaptura')),
                array('label'=>'Reporte Ciclo de Ingresos','url'=>array('balance/cicloIngresos')),
                array('label'=>'Reporte Ciclo de Ingresos Total','url'=>array('balance/cicloIngresosTotal')),
                );
        }
        //GERENTE CONTABILIDAD
        if($tipoUsuario==6)
        {
            return array(
                array('label'=>'Tablero de Control de Actv.','url'=>array('balance/controlPanel')),
                array('label'=>'Administrar Balances','url'=>array('balance/admin')),
                array('label'=>'__________REPORTES___________','url'=>array('')),
                array('label'=>'Reporte Libro Ventas','url'=>array('balance/reporteLibroVentas')),
                array('label'=>'Reporte Depositos Bancarios','url'=>array('balance/reporteDepositos')),
                array('label'=>'Reporte Brightstar','url'=>array('balance/reporteBrightstar')),
                array('label'=>'Reporte Captura','url'=>array('balance/reporteCaptura')),
                array('label'=>'Reporte Ciclo de Ingresos','url'=>array('balance/cicloIngresos')),
                array('label'=>'Reporte Ciclo de Ingresos Total','url'=>array('balance/cicloIngresosTotal')),
                );
        }
    }
}