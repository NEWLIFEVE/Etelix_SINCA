<?php
Yii::import('webroot.protected.models.Balance');
Yii::import('webroot.protected.models.Detallegasto');
class BancoController extends Controller
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
                'users' => Users::UsuariosPorTipo(4),
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
                'users' => array_merge(Users::UsuariosPorTipo(1), Users::UsuariosPorTipo(2)),
            ),
        );
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$banco=Banco::model()->find('Id=:id',array(':id'=>$id));
		$balances=Balance::model()->findAll('CUENTA_Id=:id AND FechaDep=:fecha',array(':id'=>$banco->CUENTA_Id,':fecha'=>$banco->Fecha));
		$gastos=Detallegasto::model()->findAll('FechaTransf=:fecha AND CUENTA_Id=:id',array(':id'=>$banco->CUENTA_Id,':fecha'=>$banco->Fecha));
		$this->render('view',array(
			'model'=>$banco,
			'balances'=>$balances,
			'gastos'=>$gastos
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Banco;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Banco']))
		{
			$model->attributes=$_POST['Banco'];
			$model->CUENTA_Id=$_POST['Banco']['CUENTA_Id'];
                        $model->SaldoApBanco=Utility::ComaPorPunto($_POST['Banco']['SaldoApBanco']);
                        $model->Fecha=Yii::app()->format->formatDate($_POST['Banco']['Fecha'],'post');
//                        $model->Fecha = date("Y-m-d ", time());
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

		if(isset($_POST['Banco']))
		{
			$model->attributes=$_POST['Banco'];
                        $model->Fecha =Yii::app()->format->formatDate($_POST['Banco']['Fecha'],'post');
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
		$dataProvider=new CActiveDataProvider('Banco');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Banco('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Banco']))
			$model->attributes=$_GET['Banco'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Banco the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Banco::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Banco $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='banco-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    /**
     *
     */    
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
                
                
            );
        }
        if($tipoUsuario == 3)
        {
            return array( 
              
            );
        }
        if($tipoUsuario == 4)
        {
            return array(  
                array('label' => 'Verificar Depositos Bancarios', 'url' => array('deposito/checkBanco')),
                array('label' => 'Declarar Saldo Apertura', 'url' => array('banco/create')),
                array('label' => 'Administrar Banco', 'url' => array('banco/admin')),
                array('label' => 'Declarar Gastos por Transferencia', 'url' => array('detallegasto/create')),
                array('label' => 'Actualizar Paridad Cambiaria', 'url' => array('paridad/create')),
                
              
            );
        }
        if($tipoUsuario == 5)
        {
            return array(
                array('label' => 'Administrar Banco', 'url' => array('banco/admin')),
            );
        }
    }        
}
