<?php

class CabinaController extends Controller
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
                    array('allow', // allow all users to perform 'index' and 'view' actions
                        'actions' => array(
                            'index',
                            'view',
                            'create',
                            'update',
                            'UpdateHours',
                            'admin',
                        ),
                        'users' => Users::UsuariosPorTipo(2),
                    ),
                    array('allow', // allow all users to perform 'index' and 'view' actions
                        'actions' => array(
                            'index',
                            'view',
                            'create',
                            'update',
                            'UpdateHours',
                            'admin',
                        ),
                        'users' => Users::UsuariosPorTipo(3),
                    ),
                    array('allow', // allow all users to perform 'index' and 'view' actions
                        'actions' => array(
                            'index',
                            'view',
                            'create',
                            'update',
                            'UpdateHours',
                            'admin',
                        ),
                        'users' => Users::UsuariosPorTipo(4),
                    ),
                    array('allow', // allow all users to perform 'index' and 'view' actions
                        'actions' => array(
                            'index',
                            'view',
                            'create',
                            'UpdateHours',
                            'admin',
                        ),
                        'users' => Users::UsuariosPorTipo(5),
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
		$model=new Cabina;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cabina']))
		{
			$model->attributes=$_POST['Cabina'];
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

		if(isset($_POST['Cabina']))
		{
			$model->attributes=$_POST['Cabina'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->Id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
        
        public function actionUpdateHours($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cabina']))
		{
			$model->attributes=$_POST['Cabina'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('updateHours',array(
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
		$dataProvider=new CActiveDataProvider('Cabina');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Cabina('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cabina']))
			$model->attributes=$_GET['Cabina'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cabina the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cabina::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cabina $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cabina-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
    public static function controlAcceso($tipoUsuario)
    {
    	$model=loadModel($idModelo);

    	if($tipoUsuario==1)
    	{
    		return array(
    			array(
    				'label'=>'List Cabina',
    				'url'=>array(
    					'index'
    					)
    				),
    			array(
    				'label'=>'Create Cabina',
    				'url'=>array(
    					'create'
    					)
    				),
    			array(
    				'label'=>'Update Cabina',
    				'url'=>array(
    					'update', 
    					'id'=>$model->Id
    					)
    				),
    			);
    	}
    	if($tipoUsuario==2)
    	{
    		return array(
    			array(
    				'label'=>'Delete Cabina',
    				'url'=>'#',
    				'linkOptions'=>array(
    					'submit'=>array(
    						'delete',
    						'id'=>$model->Id
    						),
    					'confirm'=>'Are you sure you want to delete this item?'
    					)
    				),
    			array(
    				'label'=>'Manage Cabina',
    				'url'=>array(
    					'admin'
    					)
    				),
    			);
    	}
    	if($tipoUsuario==3)
    	{
    		return array(
    			array(
    				'label'=>'List Cabina',
    				'url'=>array(
    					'index'
    					)
    				),
    			array(
    				'label'=>'Create Cabina',
    				'url'=>array(
    					'create'
    					)
    				),
    			array(
    				'label'=>'Update Cabina',
    				'url'=>array(
    					'update',
    					'id'=>$model->Id
    					)
    				),
    			array(
    				'label'=>'Delete Cabina',
    				'url'=>'#',
    				'linkOptions'=>array(
    					'submit'=>array(
    						'delete',
    						'id'=>$model->Id
    						),
    					'confirm'=>'Are you sure you want to delete this item?'
    					)
    				),
    			array(
    				'label'=>'Manage Cabina',
    				'url'=>array(
    					'admin'
    					)
    				),
    			);
    	}
    }
    
    /**
     *
     */     
    public static function getNombreCabina($idCabina)
    {
    	$criteria = new CDbCriteria;
    	$criteria->condition = 'Id=:cabina_id';
    	$criteria->params = array(
    		':cabina_id' => $idCabina
    		);

    	$resultSet = Cabina::model()->find($criteria);
    	if(isset($resultSet))
    	{
    		return $resultSet->Nombre;
    	}
    	else
    	{
    		switch (Yii::app()->user->id)
    		{
    			case 2:
    				return 'gerente';
    				break;
                case 3:
                    return 'administrador';
                    break;
                case 4:
                    echo "tesorero";
                    break;
                case 5:
                    echo "socio";
                    break;
            }
        }
    }
}
