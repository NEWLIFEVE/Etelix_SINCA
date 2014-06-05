<?php
error_reporting(E_ALL & ~E_NOTICE | E_STRICT);
Yii::import('webroot.protected.controllers.LogController');

class DepositoController extends Controller
{
        public $layout = '//layouts/column2';
    
	public function actionIndex()
	{
		$this->render('index');
	}

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
        
        public function accessRules()
        {
            /* 1-Operador de Cabina
             * 2-Gerente de Operaciones
             * 3-Administrador
             * 4-Tesorero
             * 5-Socio
             */
            return array(
                array('allow', //Lo que vera el socio
                    'actions'=>array(
                        'index',
                        'reporteDepositos',
                        'reporteBrightstar',
                        'reporteCaptura',
                        'cicloIngresos',
                        'cicloIngresosTotal',
                        'pop',
                        'EnviarEmail',
                        'excel'
                    ),
                    'users'=>array_merge(Users::UsuariosPorTipo(5)),
                ),
                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions'=>array(
                        'brightstar',
                        'captura',
                        'checkBanco',
                        'mostrarFinal',
                        'updateMonto',
                        'reporteLibroVentas',
                        'reporteDepositos',
                        'reporteCaptura',
                        'reporteBrightstar',
                        'index',
                        'guardarExcelBD',
                        'upload',
                        'pop',
                        'view',
                        'viewall',
                        'cicloIngresos',
                        'cicloIngresosTotal',
                        'controlPanel',
                        'subirCaptura',
                        'admin',
                        'EnviarEmail',
                        'update',
                        'excel',
                        'UploadFullCarga',
                        'CheckBanco',
                        'UpdateMonto',
                        'MostrarFinal',
                    ),
                    'users'=>array_merge(Users::UsuariosPorTipo(4)),
                ),
                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions'=>array(
                        'brightstar',
                        'captura',
                        'checkBanco',
                        'mostrarFinal',
                        'updateMonto',
                        'reporteLibroVentas',
                        'reporteDepositos',
                        'reporteCaptura',
                        'reporteBrightstar',
                        'index',
                        'guardarExcelBD',
                        'upload',
                        'pop',
                        'view',
                        'viewall',
                        'cicloIngresos',
                        'cicloIngresosTotal',
                        'controlPanel',
                        'subirCaptura',
                        'admin',
                        'EnviarEmail',
                        'update',
                        'excel'
                    ),
                    'users'=>array_merge(Users::UsuariosPorTipo(6)),
                ),
                array('allow',
                    'actions'=>array(
                        'reporteLibroVentas',
                        'reporteDepositos',
                        'reporteCaptura',
                        'reporteBrightstar',
                        'index',
                        'guardarExcelBD',
                        'upload',
                        'pop',
                        'view',
                        'viewall',
                        'create',
                        'update',
                        'CheckBanco',
                        'UpdateMonto',
                        'MostrarFinal',
                    ),
                    'users'=>array_merge(Users::UsuariosPorTipo(3)),
                ),
                array('allow',
                    'actions'=>array(
                        'reporteLibroVentas',
                        'reporteDepositos',
                        'reporteCaptura',
                        'captura',
                        'reporteBrightstar',
                        'brightstar',
                        'index',
                        'guardarExcelBD',
                        'upload',
                        'pop',
                        'view',
                        'viewall',
                        'cicloIngresos',
                        'cicloIngresosTotal',
                        'controlPanel',
                        'subirCaptura',
                        'admin',
                        'EnviarEmail',
                        'update',
                        'excel',
                        'UploadFullCarga'
                    ),
                    'users'=>array_merge(Users::UsuariosPorTipo(2)),
                ),
                array('allow', // allow all users to perform 'index' and 'view' actions
                    'actions'=>array(
                        'view',
                        'viewall',
                        'createApertura',
                        'createDeposito',
                        'createLlamadas',
                        'createCierre',
                        'createAperturaEsp',
                        'admin',
                        'EnviarEmail',
                        'excel',
                        'CheckBanco',
                    ),
                    'users'=>array_merge(Users::UsuariosPorTipo(1)),
                ),
                array('deny', // deny all users
                    'users'=>array('*'),
                ),
            );
        }
        
        public function actionCreateDeposito()
        {
            $model=new Deposito;

            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);

            if(isset($_POST['Deposito']))
            {

                $list=explode('/', $_POST['Deposito']['Fecha']);
                $fechaAux=$list[2]."-".$list[1]."-".$list[0];

                $list2=explode('/', $_POST['Deposito']['FechaCorrespondiente']);
                $fechaAux2=$list2[2]."-".$list2[1]."-".$list2[0];

                $cabina = Yii::app()->getModule('user')->user()->CABINA_Id; 

                $balanceExistente = SaldoCabina::model()->find('Fecha=:fecha AND CABINA_Id=:cabina',array(':fecha'=>$fechaAux2,':cabina'=>$cabina));
                if($balanceExistente!=null)
                {
                    $model->attributes = $_POST['Deposito'];

                    $model->MontoDep = str_replace(',','.',$_POST['Deposito']['MontoDep']);
                    $model->Fecha = $fechaAux;
                    $model->FechaCorrespondiente = $fechaAux2;
                    $model->Hora=Utility::ChangeTime($_POST['Deposito']['Hora']);
                    $model->CABINA_Id = $cabina;

                    if(isset($_POST['Deposito']['TiempoCierre']) && $_POST['Deposito']['TiempoCierre'] != '')
                        $model->TiempoCierre = $_POST['Deposito']['TiempoCierre'];

                    if($cabina == 17) 
                        $model->CUENTA_Id=2;
                    else 
                        $model->CUENTA_Id=4;

                    if($model->save())
                    {
                        LogController::RegistrarLog(4,$fechaAux);
                        $this->redirect(array('balance/view','id'=>SaldoCabina::getIdFromDate($fechaAux2,$cabina)));
                    }
                }
                else
                {
                    Yii::app()->user->setFlash('error', "ERROR: No Existe Deposito para la Fecha Indicada");
                    $model=new Deposito;
                    $this->redirect(array('createDeposito'));
                }

            }

            $this->render('createDeposito', array(
                'model'=>$model,
            ));
        }
        
        public function actionReporteDepositos()
        {
            $model=new SaldoCabina('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['SaldoCabina'])) $model->attributes=$_GET['SaldoCabina'];

            $this->render('reporteDepositos', array(
                'model'=>$model,
            ));
        }
        
        public function actionCheckBanco()
        {
            $model = new Deposito('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['Deposito'])) $model->attributes=$_GET['Deposito'];

            $this->render('checkBanco', array(
                'model'=>$model,
            ));
        }
        
        public function actionUpdateMonto()
        {
            $idBalancesActualizados="";
            $i = 0;

            //creo el parametro de busqueda
            $criteria=new CDbCriteria();
            $criteria->addCondition('MontoBanco IS NULL'); //busco solo los registros que MontoBanco sea NULL
            $criteria->addCondition('MontoDep IS NOT NULL'); //busco solo los registros que MontoDeposito no sea NULL
            //instancio el modelo
            $model=Deposito::model()->find($criteria);
            //asigno el id para usarlo luego
            $id=$model->id;
            
            while($model->id!=null)
            {
                if(isset($_POST['MontoBanco'.$id]) && $_POST['MontoBanco'.$id]!=null && is_numeric($_POST['MontoBanco'.$id]))
                {

                    $model->MontoBanco=$_POST['MontoBanco'.$id];
                    if($model->CABINA_Id==17)
                    {
                        $model->CUENTA_Id=2;
                    }
                    else
                    {
                        $model->CUENTA_Id=4;
                    }

                    $modelCicloIngreso = CicloIngresoModelo::model()->find("Fecha = '$model->FechaCorrespondiente' AND CABINA_Id = $model->CABINA_Id");
                    if($modelCicloIngreso == NULL){
                        $modelCicloIngreso = new CicloIngresoModelo;
                        $modelCicloIngreso->Fecha = $model->FechaCorrespondiente;
                        $modelCicloIngreso->CABINA_Id = $model->CABINA_Id;
                        $modelCicloIngreso->ConciliacionBancaria = round(($_POST['MontoBanco'.$id]-$model->MontoDep),2);
                        $modelCicloIngreso->DiferencialBancario = round(($_POST['MontoBanco'.$id]-Detalleingreso::getLibroVentas("LibroVentas","TotalVentas", $model->FechaCorrespondiente, $model->CABINA_Id)),2);

                        if($model->save())
                        {
                            $idBalancesActualizados.=$model->id.'A';
                            $model=Deposito::model()->find($criteria);
                            $id=$model->id;
                            
                            if($modelCicloIngreso->save())
                                $i++;
                                
                        }
                        
                    }elseif($modelCicloIngreso != NULL){
                        
                        $modelCicloIngreso = CicloIngresoModelo::model()->find("Fecha = '$model->FechaCorrespondiente' AND CABINA_Id = $model->CABINA_Id");
                        $modelCicloIngreso->ConciliacionBancaria = round(($_POST['MontoBanco'.$id]-$model->MontoDep),2);
                        $modelCicloIngreso->DiferencialBancario = round(($_POST['MontoBanco'.$id]-Detalleingreso::getLibroVentas("LibroVentas","TotalVentas", $model->FechaCorrespondiente, $model->CABINA_Id)),2);

                        if($model->save())
                        {
                            $idBalancesActualizados.=$model->id.'A';
                            $model=Deposito::model()->find($criteria);
                            $id=$model->id;
                            
                            if($modelCicloIngreso->save())
                                $i++;
                        }
                        
                    }

                }
                else
                {
                    $criteria->addCondition('id > '.$id);
                    $model=Deposito::model()->find($criteria);
                    $id=$model->id;
                }
            }
            
            if($i > 0){
                $this->redirect(array('mostrarFinal','id'=>$model->id,'idBalancesActualizados'=>$idBalancesActualizados));
            }elseif($i == 0){
                Yii::app()->user->setFlash('error', "ERROR: No se ha Ingresado Ningun Monto de Banco");
                $this->redirect(array('checkBanco')); 
            }    
        }
        
        public function actionMostrarFinal()
        {
            $model=new Deposito('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['Deposito'])) $model->attributes = $_GET['Deposito'];
            $this->render('mostrarFinal', array(
                'model'=>$model,
            ));
        }
        
        public function loadModel($id)
        {
            $model = Deposito::model()->findByPk($id);
            if ($model===null) throw new CHttpException(404, 'The requested page does not exist.');
            return $model;
        }

        /**
         * Performs the AJAX validation.
         * @param Balance $model the model to be validated
         */
        protected function performAjaxValidation($model) 
        {
            if(isset($_POST['ajax']) && $_POST['ajax']==='balance-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        }
        
        public static function controlAcceso($tipoUsuario)
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
                    array('label'=>'Reporte FullCarga','url'=>array('balance/reporteBrightstar')),
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
                    array('label'=>'Reporte FullCarga','url'=>array('detalleingreso/reporteFullCarga')),
                    array('label'=>'Reporte Captura','url'=>array('detalleingreso/reporteCaptura')),
                    array('label'=>'Reporte Ciclo de Ingresos','url'=>array('balance/cicloIngresos')),
                    array('label'=>'Reporte Ciclo de Ingresos Total','url'=>array('balance/cicloIngresosTotal')),
                    );
            }
            //TESORERO
            if($tipoUsuario==4)
            {
                return array(
                    array('label'=>'Reporte Libro Ventas','url'=>array('detalleingreso/reporteLibroVentas')),
                    array('label'=>'Reporte Depositos Bancarios','url'=>array('deposito/reporteDepositos')),
                    array('label'=>'Reporte FullCarga','url'=>array('balance/reporteBrightstar')),
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
                    array('label'=>'Reporte FullCarga','url'=>array('balance/reporteBrightstar')),
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
                    array('label'=>'Reporte FullCarga','url'=>array('balance/reporteBrightstar')),
                    array('label'=>'Reporte Captura','url'=>array('balance/reporteCaptura')),
                    array('label'=>'Reporte Ciclo de Ingresos','url'=>array('balance/cicloIngresos')),
                    array('label'=>'Reporte Ciclo de Ingresos Total','url'=>array('balance/cicloIngresosTotal')),
                    );
            }
        }
	
}