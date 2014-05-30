<?php
error_reporting(E_ALL & ~E_NOTICE | E_STRICT);
Yii::import('webroot.protected.controllers.LogController');

class SaldocabinaController extends Controller
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
                        'UploadFullCarga'
                    ),
                    'users'=>array_merge(Users::UsuariosPorTipo(4)),
                ),
                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions'=>array(
                        'brightstar',
                        'captura',
                        'checkBanco',
                        'mostrarFinal',
                        'update',
                        'excel'
                    ),
                    'users'=>array_merge(Users::UsuariosPorTipo(6)),
                ),
                array('allow',
                    'actions'=>array(
                        'CreateApertura',
                        'CreateCierre',
                        'reporteCaptura',
                        'excel',
                        'UploadFullCarga',
                    ),
                    'users'=>array_merge(Users::UsuariosPorTipo(3)),
                ),
                array('allow',
                    'actions'=>array(
                        'reporteLibroVentas',
                        'reporteDepositos',
                        'reporteCaptura',
                        'captura',
                        'UploadFullCarga'
                    ),
                    'users'=>array_merge(Users::UsuariosPorTipo(2)),
                ),
                array('allow', // allow all users to perform 'index' and 'view' actions
                    'actions'=>array(
                        'CreateApertura',
                        'CreateCierre',

                    ),
                    'users'=>array_merge(Users::UsuariosPorTipo(1)),
                ),
                array('deny', // deny all users
                    'users'=>array('*'),
                ),
            );
        }
        
        public function actionCreateApertura()
        {
            $model=new SaldoCabina;
            $model->scenario='declararApertura';
            $this->performAjaxValidation($model);
            if(isset($_POST['SaldoCabina']))
            {
                $cabina=Yii::app()->getModule('user')->user()->CABINA_Id;
                $list=explode('/', $_POST['SaldoCabina']['Fecha']);
                $fecha = $list[2]."-".$list[1]."-".$list[0];

                $balanceExistente = SaldoCabina::model()->find('Fecha=:fecha AND CABINA_Id=:cabina',array(':fecha'=>$fecha,':cabina'=>$cabina));
                if($balanceExistente!=null)
                {
                    Yii::app()->user->setFlash('error', "ERROR: Esta Cabina ya tiene un Registro de Apertura para el dia Seleccionado");
                    $this->redirect(array('createApertura'));
                }
                else
                {
                    $model->Fecha = $fecha;
                    $model->SaldoAp = str_replace(',','.',$_POST['SaldoCabina']['SaldoAp']);      
                    $model->COMPANIA_Id = 12;
                    $model->CABINA_Id = $cabina;
                    if($model->save())
                    {
                        LogController::RegistrarLog(2,$fecha);
                        $this->redirect(array('/detalleingreso/adminBalance'));
                    }
                }
            }
            $this->render('createApertura', array(
                'model'=>$model,
            ));
        }
        
        public function actionCreateCierre()
        {
            $model=new SaldoCabina;
            $model->scenario='declararApertura';
            $this->performAjaxValidation($model);
            if(isset($_POST['SaldoCabina']) && $_POST['SaldoCabina']['SaldoCierre']!=NULL)
            {
                $list=explode('/', $_POST['SaldoCabina']['Fecha']);
                $fecha=$list[2]."-".$list[1]."-".$list[0];
                $cabina=Yii::app()->getModule('user')->user()->CABINA_Id;
                $SaldoApertura=SaldoCabina::model()->find('Fecha=:fecha AND SaldoAp>=0 AND CABINA_Id=:cabina', array(':fecha'=>$fecha,':cabina'=>$cabina));
                if($SaldoApertura->Id!=null)
                {
                    $SaldoApertura->SaldoCierre = str_replace(',','.',$_POST['SaldoCabina']['SaldoCierre']);
                    if($SaldoApertura->save())
                    {
                        LogController::RegistrarLog(8,$fecha);
                        $this->redirect(array('/detalleingreso/adminBalance'));
                    }
                }
                else
                {
                    Yii::app()->user->setFlash('error', "ERROR: No Existe Balance para la Fecha Indicada");
                    $model=new SaldoCabina;
                    $this->redirect(array('createCierre'));
                }
            }
            $this->render('createCierre', array(
                'model'=>$model,
            ));
        }
        
        public function loadModel($id)
        {
            $model = SaldoCabina::model()->findByPk($id);
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
                    array('label'=>'Reporte Brightstar','url'=>array('balance/reporteBrightstar')),
                    array('label'=>'Reporte Captura','url'=>array('balance/reporteCaptura')),
                    array('label'=>'Reporte Ciclo de Ingresos','url'=>array('detalleingreso/cicloIngresos')),
                    array('label'=>'Reporte Ciclo de Ingresos Total','url'=>array('detalleingreso/cicloIngresosTotal')),
                    );
            }
            //TESORERO
            if($tipoUsuario==4)
            {
                return array(
                    array('label'=>'Reporte Libro Ventas','url'=>array('balance/reporteLibroVentas')),
                    array('label'=>'Reporte Depositos Bancarios','url'=>array('balance/reporteDepositos')),
                    array('label'=>'Reporte Brightstar','url'=>array('balance/reporteBrightstar')),
                    array('label'=>'Reporte Captura','url'=>array('balance/reporteCaptura')),
                    array('label'=>'Reporte Ciclo de Ingresos','url'=>array('balance/cicloIngresos')),
                    array('label'=>'Reporte Ciclo de Ingresos Total','url'=>array('balance/cicloIngresosTotal')),
                    array('label'=>'_____________________________','url'=>array('')),
                    array('label'=>'Administrar Balances','url'=>array('balance/admin')),
                    array('label'=>'Tablero de Control de Actv.','url'=>array('balance/controlPanel')),
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