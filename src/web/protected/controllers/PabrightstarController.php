<?php

class PabrightstarController extends Controller
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
	 public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(
                    'index',
                    'view',
                    'create',
                    'update',
                    'admin',
                    'enviarEmail',
                    'delete'
                ),
                'users' => Users::UsuariosPorTipo(2),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(
                    'index',
                    'view',
                    'create',
                    'update',
                    'admin',
                    'enviarEmail',
                    'delete'
                ),
                'users' => Users::UsuariosPorTipo(3),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(
                    'index',
                    'view',
                    'admin',
                    'enviarEmail'
                ),
                'users' => Users::UsuariosPorTipo(5),
            ),
            array('deny', // deny all users
                'users' => array_merge(Users::UsuariosPorTipo(1), Users::UsuariosPorTipo(4)),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
            $model=new Pabrightstar;
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);

            if (isset($_POST['Pabrightstar']))
            {
                $model->attributes  = $_POST['Pabrightstar'];
//                $fechaAux           = $model->Fecha;
//                $list               = explode('/', $fechaAux);
//                $model->Fecha       = $list[2] . "-" . $list[1] . "-" . $list[0];
                $model->Fecha = date("Y-m-d");
                $resultSet = Pabrightstar::model()->find('Fecha=:fecha AND Compania=:compania', array(':fecha'=>$model->Fecha,':compania'=>$model->Compania));
                if($resultSet != null)
                {
                    if(is_null($resultSet->TransferenciaPA)){
                       $comision=  Comision::getUltimaComision($_POST['Pabrightstar']['Compania']);
                        $resultSet->ComisionPA = $_POST['Pabrightstar']['TransferenciaPA']*$comision;
                        $resultSet->TransferenciaPA = $_POST['Pabrightstar']['TransferenciaPA'];
                        if ($resultSet->save()){
                            Yii::app()->user->setFlash('success',"Se registro la Transferencia del dia de hoy con exito!");
                            $this->redirect(array('view', 'id' => $resultSet->Id));
                        }
                    }
                    else
                    {
                        $comision=  Comision::getUltimaComision($_POST['Pabrightstar']['Compania']);
                        $resultSet->ComisionPA = ($resultSet->TransferenciaPA + $_POST['Pabrightstar']['TransferenciaPA'])*$comision;
                        $resultSet->TransferenciaPA = $resultSet->TransferenciaPA + $_POST['Pabrightstar']['TransferenciaPA'];
                        if ($resultSet->save()){
                            Yii::app()->user->setFlash('success',"Se registro la Transferencia del dia de hoy con exito!");
                            $this->redirect(array('view', 'id' => $resultSet->Id));
                        }
                        /********************************/
//                        Yii::app()->user->setFlash('error',"Ya existe un registro de Transferencia para esta Compañia en La Fecha indicada");
//                        $model->unsetAttributes();
                    }
                }
                else
                {
                    Yii::app()->user->setFlash('error',"No existe un registro para el dia de hoy, comuniquese con el administrador del sistema");
                    $model->unsetAttributes();
                }

//                    $comision=  Comision::getUltimaComision($model->Compania);
//                    $model->ComisionPA = $model->TransferenciaPA*$comision;
                    
//                    $num=$model->count(
//					array(
//						'condition'=>'Fecha=:fecha and Compania=:compania',
//						'params'=>array(
//							':fecha'=>$model->Fecha,
//							':compania'=>$model->Compania,
//							),
//						)
//					);
//                    if($num>1)
                    
                    /* BUSCO EN BD EL REGISTRO QUE COINCIDA CON LA DATA */
//            $sql = "SELECT id FROM pabrightstar where Fecha=:fecha AND Compania=:compania and TransferenciaPA is NULL";
//            $connection = Yii::app()->db;
//            $command = $connection->createCommand($sql);
//            $command->bindValue(":fecha", $model->Fecha, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
//            $command->bindValue(":compania", $model->Compania); //bind del parametro fecha dada por el usuario          
//            $id = $command->query(); // execute a query SQL
//            $post = $model->findByPk($id->readColumn(0));
            
//                $post= Pabrightstar::model()->find('Fecha=:fecha AND Compania=:compania AND TransferenciaPA>=:trans', array(':fecha'=>$model->Fecha,':compania'=>$model->Compania,':trans'=>0));
//                if($post->Id != null)
//                {
//                    Yii::app()->user->setFlash('error',"Ya existe un registro de Transferencia para esta Compañia en La Fecha indicada");
//
//                }
//                else
//                {
//                    $post->ComisionPA  = $model->ComisionPA; 
//                    $post->TransferenciaPA = $model->TransferenciaPA;
//                    if ($post->save())
//                        Yii::app()->user->setFlash('success',"Se registro la Transferencia del dia de hoy con exito!");
//                    //$model->unsetAttributes();
//                    $this->redirect(array('view', 'id' => $post->Id));
//                }
            
//                    if(is_null($post->Id))
//			{
//                            Yii::app()->user->setFlash('error',"Ya existe un registro de Transferencia para esta Compañia en La Fecha indicada");
//                            
//			}
//			else
//			{   
//                            $post->ComisionPA  = $model->ComisionPA; 
//                            $post->TransferenciaPA = $model->TransferenciaPA;
//                            if ($post->save())
//                                Yii::app()->user->setFlash('success',"Se registro la Transferencia del dia de hoy con exito!");
//                            //$model->unsetAttributes();
//                            $this->redirect(array('view', 'id' => $post->Id));
//                        }
            }
            $this->render('create',array(
                    'model'=>$model,
            ));
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
		 $this->performAjaxValidation($model);

		if(isset($_POST['Pabrightstar']))
		{
			$model->attributes=$_POST['Pabrightstar'];
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
		$dataProvider=new CActiveDataProvider('Pabrightstar');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Pabrightstar('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pabrightstar']))
			$model->attributes=$_GET['Pabrightstar'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pabrightstar the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Pabrightstar::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pabrightstar $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pabrightstar-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionEnviarEmail()
    {
    	Yii::app()->enviarEmail->enviar($_POST);
        $this->redirect($_POST['vista']);
    }
        
    public function actionUpload() 
    {
        Yii::import("ext.EAjaxUpload.qqFileUploader");
        $folder = 'uploads/'; // folder for uploaded files
        $allowedExtensions = array("xls"); //array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 1 * 1024 * 1024; // maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

        $fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
        $fileName = $result['filename']; //GETTING FILE NAME
    }

    /*
    * action encargada de mostrar gridview con los valores de la comision por cabina por mes
    * 
    * esta action recibe como parametro el nombre de la compania
    */
    public function actionComision($compania)
    {
        $model=new Balance;
        $idCompania=Compania::getId($compania);
        $this->render('comision',array('model'=>$model, 'compania'=>$compania));
    }

    public static function controlAcceso($tipoUsuario)
    {
        if($tipoUsuario == 1)
        {
            return array(
            );
        }
        if($tipoUsuario == 2)
        {
            return array(
                array('label' => 'Declarar  P.A. Brightstar', 'url' => array('pabrightstar/create')),
                array('label' => 'Pronosticos P.D.V. Movistar', 'url' => array('recargas/pronostico/movistar')),
                array('label' => 'Pronosticos P.D.V. Claro', 'url' => array('recargas/pronostico/claro')),
                array('label' => 'P.D.V Movistar', 'url' => array('pabrightstar/comision/movistar')),
                array('label' => 'P.D.V Claro', 'url' => array('pabrightstar/comision/claro')),
                array('label' => 'Hacer Recargas a P.D.V.', 'url' => array('recargas/create')),
                array('label' => 'Actualizar Comision P.A.', 'url' => array('comision/create')),
                array('label' => '__________REPORTES___________', 'url' => array('')),
                array('label' => 'Reporte P.A. Brightstar', 'url' => array('pabrightstar/admin')),
                array('label' => '_____________________________', 'url' => array('')),
            );
        }
        if($tipoUsuario == 3)
        {
            return array( 
                array('label' => 'Declarar  P.A. Brightstar', 'url' => array('pabrightstar/create')),
                array('label' => 'Pronosticos P.D.V. Movistar', 'url' => array('recargas/pronostico/movistar')),
                array('label' => 'Pronosticos P.D.V. Claro', 'url' => array('recargas/pronostico/claro')),
                array('label' => 'P.D.V Movistar', 'url' => array('pabrightstar/comision/movistar')),
                array('label' => 'P.D.V Claro', 'url' => array('pabrightstar/comision/claro')),
                array('label' => 'Hacer Recargas a P.D.V.', 'url' => array('recargas/create')),
                array('label' => 'Actualizar Comision P.A.', 'url' => array('comision/create')),
                array('label' => 'Administrar Comisiones P.A.', 'url' => array('comision/admin')),
                array('label' => '__________REPORTES___________', 'url' => array('')),
                array('label' => 'Reporte P.A. Brightstar', 'url' => array('pabrightstar/admin')),
                array('label' => '_____________________________', 'url' => array('')),
            );
        }
        if($tipoUsuario == 4)
        {
            return array(

            );
        }
        if($tipoUsuario == 5)
        {
            return array(
                array('label' => 'Reporte P.A. Brightstar', 'url' => array('pabrightstar/admin')),
            );
        }
           if($tipoUsuario == 6)
        {
            return array(
                array('label' => 'P.D.V Movistar', 'url' => array('pabrightstar/comision/movistar')),
                array('label' => 'P.D.V Claro', 'url' => array('pabrightstar/comision/claro')),
            );
        }
    }
}
