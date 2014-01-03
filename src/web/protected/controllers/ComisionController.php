<?php

class ComisionController extends Controller
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
                    'delete'
                ),
                'users' => Users::UsuariosPorTipo(3),
            ),
            array('deny', // deny all users
                'users' => array_merge(Users::UsuariosPorTipo(1), Users::UsuariosPorTipo(4), Users::UsuariosPorTipo(5)),
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
		$model=new Comision;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Comision']))
		{
                    $model->attributes=$_POST['Comision'];
                    $model->Fecha=Yii::app()->format->formatDate($_POST['Comision']['Fecha'],'post');
                    if($model->save())
                            $this->redirect(array('view','id'=>$model->Id));
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
		// $this->performAjaxValidation($model);

		if(isset($_POST['Comision']))
		{
			$model->attributes=$_POST['Comision'];
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
		$dataProvider=new CActiveDataProvider('Comision');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Comision('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Comision']))
			$model->attributes=$_GET['Comision'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Comision the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Comision::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Comision $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='comision-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
         public static function controlAcceso($tipoUsuario) {

        if ($tipoUsuario == 1) {

            return array(
            );
        }
        if ($tipoUsuario == 2) {

            return array(
            );
        }
        if ($tipoUsuario == 3) {

            return array(
                array('label' => 'Actualizar  Comision P.A.', 'url' => array('create')),
                array('label' => 'Administrar Comisiones P.A.', 'url' => array('admin')),
            );
        }
        if ($tipoUsuario == 4) {

            return array(
                array('label' => 'Declarar  P.A. Brightstar', 'url' => array('create')),
                array('label' => 'Administrar P.A. Brightstar', 'url' => array('admin')),
            );
        }
    }
}
