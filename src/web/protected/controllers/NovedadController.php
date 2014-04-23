<?php
/**
 *
 */
class NovedadController extends Controller
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
		/**
		 * 1-Operador de Cabina
		 * 2-Gerente de Operaciones
		 * 3-Administrador
		 * 4-Tesorero
		 * 5-Socio
		 * 8-NOC
		 */
		return array(
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(
					'create',
					'admin',
					'view',
					'enviarEmail',
					'enviarNovedad'
					),
				'users'=>array_merge(Users::UsuariosPorTipo(1)),
				),
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(
					'index'
					),
				'users'=>array_merge(Users::UsuariosPorTipo(2)),
				),
			array(
				'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(
					'index',
					'create',
					'update',
                                        'updateNovedad',
					'admin',
					'delete',
					'view',
					'enviarEmail',
					'enviarNovedad',
                                        'estadoNovedades',
                                        'matrizNovedad',
                                        'matrizNovedadSemana'
					),
				'users'=>array_merge(Users::UsuariosPorTipo(3))
				),
			array(
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(
					'index',
					'admin',
					'view',
					'enviarEmail',
					'enviarNovedad'
					),
				'users'=>array_merge(Users::UsuariosPorTipo(5)),
				),
			array(
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(
					'index',
					'create',
					'admin',
					'view',
					'enviarEmail',
					'enviarNovedad'
					),
				'users'=>array_merge(Users::UsuariosPorTipo(8)),
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
	
        $model=new Novedad; 
        //$model_telefono=new NovedadTipotelefono; 

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);
                
        if(isset($_POST['Novedad']))
        {
//            var_dump($_POST['Novedad']);
            
            $model->attributes=$_POST['Novedad'];
            $this->performAjaxValidation($model);
            
            
            $model->users_id=Yii::app()->user->id;
            $model->Fecha=date("Y-m-d",time());
            $model->Hora=date("H:i:s",time());
            
            $model->Descripcion=$_POST['Novedad']['Descripcion'];
            
            if(isset($_POST['Novedad']['Num']) && $_POST['Novedad']['Num'] != ''){
                $model->Num=$_POST['Novedad']['Num'];
            }else{
                $model->Num=NULL;
            }
            
            $model->Puesto=NULL;
            $model->TIPONOVEDAD_Id=$_POST['Novedad']['TIPONOVEDAD_Id'];
            
            $model->STATUS_Id=1;

            if($model->save())
            {            
                
                $this->saveLocutorio($_POST['Novedad']['Puesto'],$model->Id);
                $this->saveTelefono($model->Id,$_POST['Novedad']['TIPOTELEFONO_Id']);
                
            	$html="<div style='padding:auto 10% auto 10%;'>".
                    "<h1 style='border: 0 none; font:150% Arial,Helvetica,sans-serif; margin: 0;".
                    "padding: 5; vertical-align: baseline;".
                    "background: url('http://fullredperu.com/themes/mattskitchen/img/line_hor.gif')".
                    "repeat-x scroll 0 100% transparent;'>".
                    "Reporte de Novedad/Falla".
                    "</h1>".
                    "<br/>".
                    "<table style='border: 0 none; font:13px/150% Arial,Helvetica,sans-serif;width:;'>".
                    "<tr style='background-color:#f8f8f8;'>".
                    "<td style='font-weight:bold;width:30%;'>ID:  </td>".
                    "<td style='width:50%;'>".$model->Id."</td>".
                    "</tr>".
                    "<tr style='background-color:#e5f1f4;'>".
                    "<td style='font-weight:bold;width:30%;'>Nombre de Cabina:  </td>".
                    "<td style='width:50%;'>".Cabina::getNombreCabina(Yii::app()->getModule('user')->user()->CABINA_Id)."</td>".
                    "</tr>".
                    "<tr style='background-color:#f8f8f8;'>".
                    "<td style='font-weight:bold;width:30%;'>Tipo de Novedad:   </td>".
                    "<td style='width:50%;'>".$model->tIPONOVEDAD->Nombre. "</td>".
                    "</tr>".
                    "<tr style='background-color:#e5f1f4;'>".
                    "<td style='font-weight:bold;width:30%;'>Fecha: </td>".
                    "<td style='width:50%;'>".$model->Fecha."</td>".
                    "</tr>".
                    "<tr style='background-color:#f8f8f8;'>".
                    "<td style='font-weight:bold;width:30%;'>Hora: </td>".
                    "<td style='width:50%;'>".$model->Hora."</td>".
                    "</tr>".
                    "<tr style='background-color:#e5f1f4;'>".
                    "<td style='font-weight:bold;width:30%;'>Descripción: </td>".
                    "<td style='width:50%;'>".$model->Descripcion."</td>".
                    "</tr>".
                    "<tr style='background-color:#f8f8f8;'>".
                    "<td style='font-weight:bold;width:30%;'>Número Telefónico: </td>".
                    "<td style='width:50%;'>".$model->Num."</td>".
                    "</tr>".
                    "<tr style='background-color:#e5f1f4;'>".
                    "<td style='font-weight:bold;width:30%;'>Tipo de Número Telefónico: </td>".
                    "<td style='width:50%;'>".NovedadTipotelefono::getTipoTelefonoRow($model->Id)."</td>".
                    "</tr>".    
                    "<tr style='background-color:#f8f8f8;'>".
                    "<td style='font-weight:bold;width:30%;'>Puesto de la Cabina: </td>".
                    "<td style='width:50%;'>".NovedadLocutorio::getLocutorioRow($model->Id)."</td>".
                    "</tr>".
                    "<tr style='background-color:#e5f1f4;'>".
                    "<td style='font-weight:bold;width:30%;'>Login Usuario: </td>".
                    "<td style='width:50%;'>".Yii::app()->getModule('user')->user($model->users_id)->username."</td>".
                    "</tr>".
                    "<tr style='background-color:#f8f8f8;'>".
                    "<td style='font-weight:bold;width:30%;'>Correo Electrónico Usuario: </td>".
                    "<td style='width:50%;'>".Yii::app()->user->email."</td>".
                    "</tr>".
                    "</table>".
                    "</div>";
                $_POST['asunto']= 'Reporte de Novedad en Cabina: '.Cabina::getNombreCabina(Yii::app()->getModule('user')->user()->CABINA_Id).' Dia: '.date("d/m/Y",time()).' Hora: '.date("h:i:s A",time());
                $_POST['html']=$html;
                //$_POST ['correoUsuario']="fallascabinasperu@sacet.biz";
                $_POST['correoUsuario']="pnfiuty.rramirez@gmail.com";

                Yii::app()->correo->sendEmail($html,$_POST['correoUsuario'],$_POST['asunto']);
                Yii::app()->user->setFlash('success', "*Su Observacion fue enviada satisfactoriamente, en breve le daremos una respuesta*");
                
                $this->redirect(array('view','id'=>$model->Id));
            }
        }
        
        $model->unsetAttributes();
        $this->render('create', array(
            'model' => $model,
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

		if(isset($_POST['Novedad']))
		{
			$model->attributes=$_POST['Novedad'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->Id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
        
        public function actionUpdateNovedad()
        {
            $model=new Novedad;
            $idBalancesActualizados='0A';
            $cont=-1;
            foreach($_POST as $campo => $valor)
            {
                $id=substr($campo,strpos($campo ,'_')+1);
                if($cont==-1)
                {
                    $cont++;
                    $idRegistros[$cont]=$id;
                }
                if($idRegistros[$cont]!=$id)
                {
                    $cont++;
                    $idRegistros[$cont]=$id;
                }
            }
            foreach($idRegistros as $id)
            {
                $modelAux = Novedad::model()->findByPk($id);
                if(isset($_POST['status_'.$id]) && $_POST['status_'.$id]==2 && isset($_POST['Observaciones_'.$id]) && $_POST['Observaciones_'.$id] !="")
                {
                    $modelAux->DESTINO_Id= DestinationInt::getId($_POST['Destino_'.$id]);
                    $modelAux->STATUS_Id=$_POST['status_'.$id];
                    $modelAux->Observaciones=$_POST['Observaciones_'.$id];
                    
                    if($modelAux->FechaCierre == NULL && $modelAux->HoraCierre == NULL){
                        $modelAux->FechaCierre=date('Y-m-d',time());
                        $modelAux->HoraCierre=date('H:i:s',time());
                    }
  
                    if($modelAux->update())
                    {
                        $idBalancesActualizados.=$modelAux->Id.'A';
                    }
                }
                elseif(isset($_POST['status_'.$id]) && $_POST['status_'.$id] <2 && $_POST['status_'.$id] > 0)
                {
                    $modelAux->DESTINO_Id=NULL;
                    $modelAux->STATUS_Id=$_POST['status_' . $id];
                    $modelAux->Observaciones=NULL;
                    $modelAux->FechaCierre=NULL;
                    $modelAux->HoraCierre=NULL;

                    if($modelAux->update())
                    {
                        $idBalancesActualizados.=$modelAux->Id.'A';
                    }
                }
            }
            //$this->redirect(array('mostrarFinal','id'=>$model->Id,'idBalancesActualizados' => $idBalancesActualizados)); 
            $this->redirect('estadoNovedades', array(
                'model' => $model,
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
		$dataProvider=new CActiveDataProvider('Novedad');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                $model=new Novedad('search');
                $model->unsetAttributes();  // clear any default values
                if(isset($_GET['Novedad'])) $model->attributes=$_GET['Novedad'];

                $this->render('admin', array(
                    'model'=>$model,
                ));
	}
        
        public function actionMatrizNovedad()
	{
                $model=new Novedad('search');
                $model->unsetAttributes();  // clear any default values
                if(isset($_GET['Novedad'])) $model->attributes=$_GET['Novedad'];

                $this->render('matrizNovedad', array(
                    'model'=>$model,
                ));
	}
        
        public function actionMatrizNovedadSemana()
	{
                $model=new Novedad('search');
                $model->unsetAttributes();  // clear any default values
                if(isset($_GET['Novedad'])) $model->attributes=$_GET['Novedad'];

                $this->render('matrizNovedadSemana', array(
                    'model'=>$model,
                ));
	}
        
        public function actionEstadoNovedades()
	{
                $model=new Novedad('search');
                $model->unsetAttributes();  // clear any default values
                if(isset($_GET['Novedad'])) $model->attributes=$_GET['Novedad'];

                $this->render('estadoNovedades', array(
                    'model'=>$model,
                ));
	}

	/**
	 *
	 */
    public function actionEnviarEmail()
    {
        Yii::app()->enviarEmail->enviar($_POST);
        $this->redirect(Yii::app()->createUrl($_POST['vista']));
        return;   
    }
    
    /**
     *
     */  
    public function actionEnviarNovedad()
    {
        Yii::app()->enviarEmail->enviar($_POST);
    }
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Novedad the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Novedad::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Novedad $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='novedad-form')
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
  		if($tipoUsuario==1)
  		{
  			return array(
  				array('label'=>'Reportar Novedad/Falla', 'url'=>array('create')),
                array('label'=>'Administrar Novedades/Fallas', 'url'=>array('admin')),
                );
  		}
  		if($tipoUsuario==2)
  		{
  			return array();
    	}
    	if($tipoUsuario==3)
    	{
    		return array(
                array('label'=>'Reportar Falla', 'url'=>array('create')),
                array('label'=>'Administrar Fallas', 'url'=>array('admin')),
                array('label'=>'Estado de Fallas', 'url'=>array('estadoNovedades')),
                array('label'=>'Matriz General de Fallas', 'url'=>array('matrizNovedad')), 
                array('label'=>'Matriz Total de TT´s por Cabina', 'url'=>array('matrizNovedadSemana')),     
                );
    	}
    	if($tipoUsuario==5)
    	{
    		return array(
                array('label'=>'Administrar Novedades/Fallas', 'url'=>array('admin')),
                );
    	}       
    	if($tipoUsuario==8)
    	{
    		return array(
                array('label'=>'Reportar Novedad/Falla', 'url'=>array('create')),
                array('label'=>'Administrar Novedades/Fallas', 'url'=>array('admin')),
                array('label'=>'Estado de Fallas', 'url'=>array('estadoNovedades')),
                array('label'=>'Matriz General de Fallas', 'url'=>array('matrizNovedad')), 
                array('label'=>'Matriz Total de TT´s por Cabina', 'url'=>array('matrizNovedadSemana')),     
                );
    	}       
    }
    
    public function saveLocutorio($array_locutorio,$novedad_id)
    {
        if(!isset($array_locutorio[0]) || $array_locutorio[0] == NULL || $array_locutorio[0] == ''){
            
        }elseif($array_locutorio[0] != 11){
            for($i=0;$i<count($array_locutorio);$i++) {
                $model_locutorio = new NovedadLocutorio;
                $model_locutorio->NOVEDAD_Id = $novedad_id;
                $model_locutorio->LOCUTORIO_Id = $array_locutorio[$i];

                $model_locutorio->save(false);
            }
        }elseif($array_locutorio[0] == 11){
            $model_locutorio = new NovedadLocutorio;
            $model_locutorio->NOVEDAD_Id = $novedad_id;
            $model_locutorio->LOCUTORIO_Id = 11;

            $model_locutorio->save(false);
        }
    }
    
    public function saveTelefono($novedad_id,$tipo_telefono)
    {
        if(isset($tipo_telefono) && $tipo_telefono != ''){
            $model_telefono = new NovedadTipotelefono;
            $model_telefono->NOVEDAD_Id = $novedad_id;
            $model_telefono->TIPOTELEFONO_Id = $tipo_telefono;
            $model_telefono->save(false);
        }
    }
    
    
    
    
    
    
}
