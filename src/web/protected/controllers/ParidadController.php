<?php

class ParidadController extends Controller
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
					),
				'users'=>Users::UsuariosPorTipo(5),
				),
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(
					'index',
					'view',
					'create',
					'update',
					'admin',
					'delete'
					),
				'users'=>Users::UsuariosPorTipo(3),
			),
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(
					'index',
					'view',
					'create',
					'update',
					'admin',
					'delete'
					),
				'users'=>Users::UsuariosPorTipo(4),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Paridad;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Paridad']))
		{
			$model->attributes=$_POST['Paridad'];
                        $model->Fecha = date("Y-m-d",time());
			if($model->save())
			{
				Yii::app()->user->setFlash('success',"Se registro el nuevo valor de Paridad Cambiaria con exito");
			}
			else
			{
				Yii::app()->user->setFlash('error',"No se pudo registrar el nuevo valor de Paridad Cambiaria, comunicarse con el administrador de sistema");
			}
		}
                $model->Valor = "";
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
		// $this->performAjaxValidation($model);

		if(isset($_POST['Paridad']))
		{
			$model->attributes=$_POST['Paridad'];
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
		$dataProvider=new CActiveDataProvider('Paridad');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Paridad('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Paridad']))
			$model->attributes=$_GET['Paridad'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Paridad the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Paridad::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Paridad $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='paridad-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
