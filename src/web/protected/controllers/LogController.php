<?php
class LogController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
        /* 1-Operador de Cabina
        * 2-Gerente de Operaciones
        * 3-Administrador
        * 4-Tesorero
        * 5-Socio
        */                                
		return array(
			array(
				'allow',
				'actions'=>array(
					'admin',
					'index',
					'view',
					'enviarEmail',
					),
				'users'=>Users::UsuariosPorTipo(5),
				),
                        array('allow', // allow admin user to perform 'admin' and 'delete' actions
                            'actions'=>array(
                                'AdminBalance',
                                'ControlPanel',
                            ),
                            'users'=>array_merge(Users::UsuariosPorTipo(4)),
                        ),
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(
					'index',
					'view',
					'create',
					'update',
					'admin',
					'delete',
					'enviarEmail',
                                        'ControlPanel',
					),
				'users'=>Users::UsuariosPorTipo(3),
				),
			array(
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(
					'createInicioJornada',
					'createFinJornada'
					),
				'users'=>Users::UsuariosPorTipo(1),
				//'users'=>array('admin','raul'),
			),
			array(
				'deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
        
        public function actionControlPanel()
        {
            $model=new Log('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Log'])) $model->attributes=$_GET['Log'];

            $this->render('controlPanel', array(
                'model'=>$model,
            ));
        }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Log;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Log']))
		{
			$model->attributes=$_POST['Log'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->Id));
		}
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 *
	 */ 
	public function actionCreateInicioJornada()
	{
		$model=new Log();
		$fecha=date("Y-m-d");
		$usuario=Yii::app()->getModule('user')->user()->id;
		$num=$model->count(array('condition'=>'Fecha=:fecha and ACCIONLOG_Id=:accion and USERS_Id=:user','params'=>array(':fecha'=>$fecha,':accion'=>9,':user'=>$usuario),));
		if($num >= 1)
		{
			$existe=true;
		}
		else
		{
			$existe=false;
			if(isset($_POST['Log']['Hora']))
			{
				if(empty($_POST['Log']['Hora']))
				{
					Yii::app()->user->setFlash('error',"Ocurrio un error notificar al administrador");
				}
				else
				{
					//los atributos los paso al modelo
					$model->attributes = $_POST['Log'];
					//agarro la fecha del sistema
					$model->Fecha = $fecha;
					//acomodo el formato de hora para la base de datos
					$hora=Utility::ChangeTime($model->Hora);
					$model->Hora = $hora;
					//Agarro el id del usuario para almacenar el registro
					$model->USERS_Id=$usuario;
					//le doy el id correspondiente del log
					$model->ACCIONLOG_Id=9;
					//$_POST = array();
					if($model->save())
					{
						unset($_POST['Log']['Hora']);
                                                //$model->Hora = '';
						Yii::app()->user->setFlash('success',"Se registro el INICIO de su jornada laboral con exito");
					}
					else
					{
						Yii::app()->user->setFlash('error',"No se pudo registrar el INICIO de jornada, comunicarse con el administrador de sistema");
					}
				}
			}
		}
		$this->render('createInicioJornada',array(
			'model'=>$model,'existe'=>$existe,
			)
		);
	}

	/**
	 *
	 */ 
	public function actionCreateFinJornada()
	{
		$contador=1;
		if(isset($_SESSION['contador']))
		{
			$contador=$contador + $_SESSION['contador'];
		}
		$_SESSION['contador']=$contador;
		//Instancio el modelo
		$model=new Log();
		//Tomo la hora del sistema
		$fecha=date("Y-m-d",time());
		//obtengo el id del usuario actual
		$usuario=Yii::app()->getModule('user')->user()->id;
		if(isset($_POST['Log']))
		{
			$num=$model->count(
					array(
						'condition'=>'Fecha=:fecha and ACCIONLOG_Id=:accion and USERS_Id=:user',
						'params'=>array(
							':fecha'=>$fecha,
							':accion'=>10,
							':user'=>$usuario
							),
						)
					);
			// si es mayor no ejecuta
			if($num >= 1)
			{
				if($contador<=3)
				{
					Yii::app()->user->setFlash('success',"Se registro el FIN de su jornada laboral con exito");
				}
				else
				{
					Yii::app()->user->setFlash('error',"Ya registro el FIN de jornada");
				}
			}
			else
			{
				//los atributos los paso al modelo
				$model->attributes = $_POST['Log'];
				//agarro la fecha del sistema
				$model->Fecha = $fecha;
				//acomodo el formato de hora para la base de datos
				$model->Hora = Utility::ChangeTime($model->Hora);
				//Agarro el id del usuario para almacenar el registro
				$model->USERS_Id=Yii::app()->getModule('user')->user()->id;
				//le doy el id correspondiente del log
				$model->ACCIONLOG_Id=10;
				if($model->save())
				{
					Yii::app()->user->setFlash('success',"Se registro el FIN de su jornada laboral con exito");
				}
				else
				{
					Yii::app()->user->setFlash('error',"No se pudo registrar el FIN de jornada, comunicarse con el administrador de sistema");
				}
				$model->Hora = "";
			}		
		}
		$this->render('createFinJornada',array(
			'model'=>$model,
			)
		);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Log']))
		{
			$model->attributes=$_POST['Log'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->Id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Log');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Log('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Log']))
			$model->attributes=$_GET['Log'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 *
	 */
	public function actionEnviarEmail()
	{
        Yii::app()->enviarEmail->enviar($_POST);
        $this->redirect($_POST['vista']);
    }
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Log the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Log::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Log $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='log-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 *
	 */
	public static function RegistrarLog($id,$fechaesp = NULL)
    {
        if(!Yii::app()->user->isGuest)
        {
            $model =new Log;
            $model->USERS_Id=Yii::app()->user->id;
            $model->ACCIONLOG_Id = $id;
            $model->Fecha=date("Y-m-d ",time());
            $model->Hora=date("H:i:s",time());
            if(isset($fechaesp))
            {
                $model->FechaEsp=$fechaesp;
            }
            $model->save();
        }
        else
        {
            Yii::app()->request->redirect(Yii::app()->createUrl('site/sessionFinished'));
        }
    }

    /**
     *
     */
    public function actionAutocompleteFinal()
    {
    	if(isset($_GET['term']))
    	{
    		$criteria = new CDbCriteria;
    		$criteria->condition = "`users`.`username` like '%" . $_GET['term'] . "%'";
    		$criteria->order = 'username';
    		$criteria->limit = 30;
            $proveedores = Cabina::model()->findAll($criteria);
            $return_array = array();
            foreach($proveedores as $proveedor)
            {
            	$return_array[] = array(
                    'label' => $proveedor->username,
                    'value' => $proveedor->username,
                    'id' => $proveedor->id,
                );
            }
            echo CJSON::encode($return_array);
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
                array('label'=>'Reporte Libro Ventas','url'=>array('balance/reporteLibroVentas')),
                array('label'=>'Reporte Depositos Bancarios','url'=>array('deposito/reporteDepositos')),
                array('label'=>'Reporte Brightstar','url'=>array('balance/reporteBrightstar')),
                array('label'=>'Reporte Captura','url'=>array('balance/reporteCaptura')),
                array('label'=>'Reporte Ciclo de Ingresos','url'=>array('balance/cicloIngresos')),
                array('label'=>'Reporte Ciclo de Ingresos Total','url'=>array('balance/cicloIngresosTotal')),
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
