<?php

class RecargasController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','pronostico','actRecargas'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
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
		$model=new Recargas;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Recargas']))
		{
			$model->attributes=$_POST['Recargas'];
                        
                        
            $cabina = $model->BALANCE_Id;
            $compania = $model->PABRIGHTSTAR_Id;
            $fecha = date("Y-m-d ", time());
            
            $modelBalance=  Balance::model()->find(array(
			'condition'=>'CABINA_Id=:cabina_id and Fecha =:fecha',
			'params'=>array(
				':cabina_id'=>$cabina,
                                            ':fecha'=>$fecha
				),
			));
            $modelPAB= Pabrightstar::model()->find(array(
			'condition'=>'Compania=:compania and Fecha =:fecha',
			'params'=>array(
				':compania'=>$compania,
                                            ':fecha'=>$fecha
				),
			));
            
            if($modelBalance!=NULL)
            {
                $model->BALANCE_Id = $modelBalance->Id;
            }
            else
            {
                $model->BALANCE_Id=0;
            }
            if($modelPAB!=NULL)
            {
                $model->PABRIGHTSTAR_Id = $modelPAB->Id;
            }
            else
            {
                $model->PABRIGHTSTAR_Id=0;
            }
            
            $model->FechaHora = date("Y-m-d H:i:s",time());
            
            //VALIDAR si existe BALANCE y PABRIGHTSTAR
            if($modelBalance!=NULL && $modelPAB!=NULL)
            {
                if($model->save())
                    $this->redirect(array('view','id'=>$model->id));
            }
            else
            {
                Yii::app()->user->setFlash('error',"No existe balance para esta cabina para el día de hoy, comuniquese con el administrador del sistema");
                $model->unsetAttributes();
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	* Accion que renderiza el gridview de pronosticos
	*
	* Renderiza la vista del gridview de pronosticos, que a su ver incluye un 
	* un form para recargar las cabinas
	* 
	* Este action solo recibe como parametro el nombre de la comparnia
	*/
	public function actionPronostico($compania)
	{
		$model=new Balance;
		$idCompania=Compania::model()->find('nombre=:nombre',array(':nombre'=>$compania))->id;
		$this->render('pronostico',array('model'=>$model,'compania'=>$compania, 'idCompania'=>$idCompania));
	}

	/**
	* Accion que procesa el fomulario de recargas de pronosticos
	*
	* Se encarga de recibir un formulario con varios campos de las recargas hacer el guardado en base de datos,
	* pero primero verifica que recargas se han hecho en el dia y compara con el saldo disponible en la plataforma 
	* administrativa de brightstar
	* 
	* Este action recibe la variable $_POST
	*/
	public function actionActRecargas($compania)
	{
		$fecha=date("Y-m")."-01";
		$idBalancesActualizados=array();
		//traigo el id de la compania
		$idCompania=Compania::model()->find('nombre=:nombre',array(':nombre'=>$compania))->id;
		//traigo el id de pabringhtstar
		$idPabrightstar=Pabrightstar::getIdPorDia(null,$idCompania);
		//verificar recargas del dia
		$recargas=Recargas::getMontoRecargaPorDia(null,$idPabrightstar);
		//verificar saldo de la plataforma administrativa
		$saldoNeto=Pabrightstar::getSaldoPorDia(null,$idCompania);
		//conciliar con las recargas pasadas por formulario
		$balances=Balance::model()->findAll("Fecha >=:fecha order by Id asc",array(':fecha'=>$fecha));
		if(!empty($_POST))
        {
        	$array=array();
        	foreach ($balances as $balance)
        	{
        		if(!empty($_POST[$compania.$balance->Id]))
        		{
        			$array[$balance->Id]=$_POST[$compania.$balance->Id];
        		}
        	}
        	if($saldoNeto>=array_sum($array))
        	{
        		foreach ($balances as $balance)
        		{
        			if(!empty($_POST[$compania.$balance->Id]) && is_numeric($_POST[$compania.$balance->Id]))
        			{
        				$recarga=new Recargas;
        				$recarga->FechaHora=date("Y-m-d G:i:s");
        				$recarga->MontoRecarga=$_POST[$compania.$balance->Id];
        				$recarga->BALANCE_Id=$balance->Id;
        				$recarga->PABRIGHTSTAR_Id=$idPabrightstar;
        				if($recarga->save())
        				{
        					array_push($idBalancesActualizados,$balance->Id);
        				}
        			}
        		}
        	}
        	else
        	{
                Yii::app()->user->setFlash('error',"El monto total de recargas debe ser menor o igual al disponible");
        		$this->redirect("/recargas/pronostico/".$compania);
        	}
        }
        $model=new Balance;
        $this->render('recargas',array('model'=>$model,'compania'=>$compania, 'idCompania'=>$idCompania, 'idBalancesActualizados'=>$idBalancesActualizados));
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

		if(isset($_POST['Recargas']))
		{
			$model->attributes=$_POST['Recargas'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('Recargas');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Recargas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Recargas']))
			$model->attributes=$_GET['Recargas'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Recargas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Recargas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Recargas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='recargas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
