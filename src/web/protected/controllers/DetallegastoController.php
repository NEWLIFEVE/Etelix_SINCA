<?php

class DetallegastoController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

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
                    'index',
                    'view',
                    'create',
                    'update',
                    'admin',
                    'delete',
                    'dynamicUsers',
                    'dynamicCuenta',
                    'dynamicCuentaEmployee',
                    'dynamicCategoria',
                    'dynamicGastoAnterior',
                    'dynamicGastoAnteriorNomina',
                    'estadoGastos',
                    'matrizGastos',
                    'matrizGastosEvolucion',
                    'filtrarPorStatus',
                    'updateGasto',
                    'mostrarFinal',
                    'enviarEmail',
                ),
                'users'=>Users::UsuariosPorTipo(2),
            ),
            array(
                'allow',
                'actions'=>array(
                    'index',
                    'view',
                    'create',
                    'update',
                    'admin',
                    'delete',
                    'dynamicUsers',
                    'dynamicCuenta',
                    'dynamicCuentaEmployee',
                    'dynamicCategoria',
                    'dynamicGastoAnterior',
                    'dynamicGastoAnteriorNomina',
                    'matrizGastos',
                    'matrizGastosEvolucion',
                    'estadoGastos',
                    'filtrarPorStatus',
                    'updateGasto',
                    'mostrarFinal',
                    'enviarEmail',
                ),
                'users'=>Users::UsuariosPorTipo(6),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions'=>array(
                    'index',
                    'view',
                    'create',
                    'update',
                    'admin',
                    'delete',
                    'dynamicUsers',
                    'dynamicCuenta',
                    'dynamicCuentaEmployee',
                    'dynamicCategoria',
                    'dynamicGastoAnterior',
                    'dynamicGastoAnteriorNomina',
                    'estadoGastos',
                    'matrizGastos',
                    'matrizGastosEvolucion',
                    'filtrarPorStatus',
                    'updateGasto',
                    'mostrarFinal',
                    'enviarEmail',
                    'matrizNomina',
                ),
                'users'=>Users::UsuariosPorTipo(3),
            ),
            array('deny', // deny all users
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
        $this->render('view', array(
            'model'=>$this->loadModel($id),
        ));
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */

    public function actionCreate() {
        $model = new Detallegasto;
        $model_cabina = new Cabina;
        //var_dump($_POST);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['Detallegasto']))
        {
            $model->attributes = $_POST['Detallegasto'];
            $model->Monto=Yii::app()->format->truncarDecimal(Utility::ComaPorPunto($_POST['Detallegasto']['Monto']));
            $model->FechaMes=$_POST['Detallegasto']['FechaMes']."-01";        
            $model->Descripcion=$_POST['Detallegasto']['Descripcion'];
            $model->CABINA_Id=$_POST['Detallegasto']['CABINA_Id'];
            $model->status=1;
            $model->USERS_Id=  Yii::app()->getModule('user')->user()->id;
            if(isset($_POST['Detallegasto']['FechaVenc']) && $_POST['Detallegasto']['FechaVenc']!= "" )
            {
                $model->FechaVenc=Yii::app()->format->formatDate($_POST['Detallegasto']['FechaVenc'],'post');
            }
            else
            {
                $model->FechaVenc=NULL;
            } 
            
//            if(isset($_POST['beneficiario2']) && $_POST['beneficiario2']!= "empty" ){
//                $model->beneficiario=  Employee::getNameEmployee($_POST['Detallegasto']['beneficiario']);
//            }else{
                $model->beneficiario=$_POST['Detallegasto']['beneficiario'];
//            } 
//            $model->USERS_Id=$_POST['USERS_Id'];

            if(isset($_POST['Detallegasto']['nombreTipoDetalle']) && $_POST['Detallegasto']['nombreTipoDetalle']!= ""){
                $model->TIPOGASTO_Id = Tipogasto::getIdGasto($_POST['Detallegasto']['nombreTipoDetalle'],$_POST['Detallegasto']['category']);
            }else{

                $model->TIPOGASTO_Id=$_POST['Detallegasto']['TIPOGASTO_Id'];
            }
            if($model->save())
                $this->redirect(array('view', 'id' => $model->Id));
        }

        $this->render('create', array(
            'model'=>$model,
            'model_cabina'=>$model_cabina,
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
        $model_cabina = new Cabina;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Detallegasto']))
        {
            $model->attributes = $_POST['Detallegasto'];
            $model->FechaMes=$_POST['Detallegasto']['FechaMes']."-01";  

            //$model->beneficiario=$_POST['Detallegasto']['beneficiario'];

            
            if(isset($_POST['Detallegasto']['FechaVenc']) && $_POST['Detallegasto']['FechaVenc']!= "" && strstr($_POST['Detallegasto']['FechaVenc'], '-')==FALSE)
            {
                $model->FechaVenc=Yii::app()->format->formatDate($_POST['Detallegasto']['FechaVenc'],'post');
            }
            else
            {
                $model->FechaVenc=NULL;
            } 
            
            if($model->save())
                $this->redirect(array('view', 'id' => $model->Id));
        }

        $this->render('update', array(
            'model'=>$model,
            'model_cabina'=>$model_cabina,
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
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Detallegasto');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Detallegasto('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Detallegasto']))
            $model->attributes = $_GET['Detallegasto'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     *
     */
    public function actionEstadoGastos()
    {
        $model=new Detallegasto('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Detallegasto']))
            $model->attributes = $_GET['Detallegasto'];

        $this->render('estadoGastos', array(
            'model' => $model,
        ));
    }

    /**
     *
     */
    public function actionMatrizGastos()
    {
        if(isset($_POST['formFecha']))
        {
            $this->render('matrizGastos', array('formFecha'=>$_POST['formFecha']));
        }
        else
        {
           $this->render('matrizGastos', array()); 
        }
    }
    
    public function actionMatrizNomina()
    {
        if(isset($_POST['formFecha']))
        {
            $this->render('matrizNomina', array('formFecha'=>$_POST['formFecha']));
        }
        else
        {
           $this->render('matrizNomina', array()); 
        }
    }
    
    public function actionMatrizGastosEvolucion() {
        if(isset($_POST['formFecha'])){
            $this->render('matrizGastosEvolucion', array('formFecha'=>$_POST['formFecha'],'formCabina'=>$_POST['formCabina']));
        }else{
           $this->render('matrizGastosEvolucion', array()); 
        }
        
    }

    /**
     *
     */
    public function actionUpdateGasto()
    {
        $model=new Detallegasto;
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
            $modelAux = Detallegasto::model()->findByPk($id);
            if(isset($_POST['status_'.$id]) && $_POST['status_'.$id]==3 && isset($_POST['NumeroTransferencia_'.$id]) && $_POST['NumeroTransferencia_'.$id] !="" && isset($_POST['FechaTransferencia_'.$id]) && $_POST['FechaTransferencia_'.$id] !="" && isset($_POST['Cuenta_'.$id]) && $_POST['Cuenta_'.$id] !="")
            {
                $modelAux->status=$_POST['status_'.$id];
                $modelAux->TransferenciaPago=$_POST['NumeroTransferencia_'.$id];
                $modelAux->CUENTA_Id=$_POST['Cuenta_'.$id];
                $modelAux->FechaTransf=Yii::app()->format->formatDate($_POST['FechaTransferencia_'.$id],'post');
                if($modelAux->update())
                {
                    $idBalancesActualizados.=$modelAux->Id.'A';
                }
            }
            elseif(isset($_POST['status_'.$id]) && $_POST['status_'.$id] <3 && $_POST['status_'.$id] > 0)
            {
                $modelAux->status=$_POST['status_' . $id];
                $modelAux->TransferenciaPago=NULL;
//                $modelAux->CUENTA_Id          = NULL;
                $modelAux->FechaTransf=NULL;
                if($modelAux->update())
                {
                    $idBalancesActualizados.=$modelAux->Id.'A';
                }
            }
        }
        //$this->redirect(array('mostrarFinal','id'=>$model->Id,'idBalancesActualizados' => $idBalancesActualizados)); 
        $this->render('estadoGastos', array(
            'model' => $model,
        ));
    }

    /**
     *
     */
    public function actionMostrarFinal()
    {
        $model=new Detallegasto;
        $this->render('mostrarFinal', array(
            'model' => $model,
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
     * @return Detallegasto the loaded model
     * @throws CHttpException
     */

    public function loadModel($id) {
        $model = Detallegasto::model()->findBySql("SELECT detallegasto.*, category.id as category
                                                    FROM detallegasto 
                                                    INNER JOIN tipogasto ON tipogasto.Id = detallegasto.TIPOGASTO_Id 
                                                    INNER JOIN category ON category.id = tipogasto.category_id
                                                    WHERE detallegasto.Id = $id");

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    

    /**
     * Performs the AJAX validation.
     * @param Detallegasto $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'detallegasto-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    /**
     *
     */
    public function actionDynamicUsers()
    {
        echo CHtml::tag('option',array('value'=>'empty'),'Seleccione uno',true);
        $data = Users::getListUsers ($_POST['Id']);
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
        }
    }

    /**
     *
     */
    public function actionDynamicCuenta()
    {
        if($_POST['Detallegasto']['moneda'] != 'empty'){
            echo CHtml::tag('option',array('value'=>'empty'),'Seleccione uno',true);
            $data = Cuenta::getListCuentaTipo($_POST['Detallegasto']['moneda']);
            foreach($data as $value=>$name)
            {
                echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
            }
        }else{
            echo CHtml::tag('option',array('value'=>''),'Seleccionar Moneda',true);
        }
    }

    public function actionDynamicCuentaEmployee()
    {
        if($_GET['moneda'] != 'empty'){
            echo CHtml::tag('option',array('value'=>'empty'),'Seleccione uno',true);
            $data = Cuenta::getListCuentaTipo($_GET['moneda']);
            foreach($data as $value=>$name)
            {
                echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
            }
        }else{
            echo CHtml::tag('option',array('value'=>''),'Seleccionar Moneda',true);
        }
    }
    
    public function actionDynamicCategoria()
    {
        $dato = '<option value="empty">Seleccione uno</option>
                <option value="new">Nuevo..</option>';
        $data = Tipogasto::getListTipoGastoCategoria($_GET['category']);
        foreach($data as $value=>$name)
        {
            $dato.= "<option value='$value'>".CHtml::encode($name)."</option>";
        }
        echo $dato;
    }

    /**
     *
     */
    public function actionDynamicGastoAnterior()
    {
        list($year, $mon, $day) = explode('-', date("Y-m-d", time()));
        $fechaMesAnterior = date('Y-m-d', mktime(0, 0, 0, $mon - 1, '01', $year));
        if (isset($_POST['Detallegasto']['TIPOGASTO_Id']) && isset($_POST['Detallegasto']['CABINA_Id']) && isset($_POST['Detallegasto']['category'])) {
            if ($_POST['Detallegasto']['category']!= 9){
            $resulset = Detallegasto::model()->find("TIPOGASTO_Id=:tipoGasto AND FechaMes=:fechaMes AND CABINA_Id=:cabinaId", array(':tipoGasto' => $_POST['Detallegasto']['TIPOGASTO_Id'], ':fechaMes' => "$fechaMesAnterior", ':cabinaId' => $_POST['Detallegasto']['CABINA_Id']));   
            if ($resulset != NULL)
                echo "<strong><span>Monto " . Utility::monthName($fechaMesAnterior) . ": </span>
                    <span style='color:forestgreen;'>$resulset->Monto</span><span> S.</span></strong>";
            else
                echo "<strong><span>Monto " . Utility::monthName($fechaMesAnterior) . ": </span>
                    <span style='color:forestgreen;'>No hay data</span><span> S.</span></strong>";
        }
         }
    }
    public function actionDynamicGastoAnteriorNomina() 
    {
        if ($_GET['beneficiario'] != 'empty') {
            list($year, $mon, $day) = explode('-', date("Y-m-d", time()));
            $fechaMesAnterior = date('Y-m-d', mktime(0, 0, 0, $mon - 1, '01', $year));

            $resulset = Detallegasto::model()->find("TIPOGASTO_Id=:tipoGasto AND FechaMes=:fechaMes AND CABINA_Id=:cabinaId AND beneficiario =:beneficiario", array(':tipoGasto' => $_GET['idGasto'], ':fechaMes' => "$fechaMesAnterior", ':cabinaId' => $_GET['idCabina'], ':beneficiario' => $_GET['beneficiario']));
            if ($resulset != NULL)
                echo "<strong><span>Monto " . Utility::monthName($fechaMesAnterior) . ": </span>
                <span style='color:forestgreen;'>$resulset->Monto</span><span> S.</span></strong>";
            else
                echo "<strong><span>Monto " . Utility::monthName($fechaMesAnterior) . ": </span>
                <span style='color:forestgreen;'>No hay data</span><span> S.</span></strong>";
        }else {
            echo '';
        }
    }

    /**
     *
     */
    public static function controlAcceso($tipoUsuario)
    {
        /* OPERADOR DE CABINA */
        if($tipoUsuario==1)
        {
            return array(
                //array('label' => 'Declarar Inicio Jornada', 'url' => array('log/createInicioJornada')),
            );
        }
        /* GERENTE DE OPERACIONES */
        if($tipoUsuario==2)
        {
            return array(
                 array('label'=>'__________INGRESOS___________','url'=>array('')),
                array('label' => 'Declarar Ingreso', 'url' => array('detalleingreso/createIngreso')),
                array('label' => 'Administrar Ingresos', 'url' => array('detalleingreso/adminIngreso')),
                array('label' => 'Matriz de Ingresos', 'url' => array('detalleingreso/matrizIngresos')),
                array('label'=>'__________GASTOS___________','url'=>array('')),
                array('label' => 'Declarar Gasto', 'url' => array('detallegasto/create')),
              //  array('label' => 'Administrar Gastos', 'url' => array('detallegasto/admin')),
                array('label' => 'Estado de Gastos', 'url' => array('detallegasto/estadoGastos')),
                array('label' => 'Matriz de Gastos', 'url' => array('detallegasto/matrizGastos')),
                array('label' => 'Matriz de Gastos Evolucion', 'url' => array('detallegasto/MatrizGastosEvolucion')),
                array('label' => 'Matriz de Nomina', 'url' => array('detallegasto/matrizNomina')),
            );
        }
        /* ADMINISTRADOR */
        if($tipoUsuario==3)
        {
            return array(
                array('label'=>'__________INGRESOS___________','url'=>array('')),
                array('label' => 'Declarar Ingreso', 'url' => array('detalleingreso/createIngreso')),
                array('label' => 'Administrar Ingresos', 'url' => array('detalleingreso/adminIngreso')),
                array('label' => 'Matriz de Ingresos', 'url' => array('detalleingreso/matrizIngresos')),
                array('label'=>'__________GASTOS___________','url'=>array('')),
                array('label' => 'Declarar Gasto', 'url' => array('detallegasto/create')),
              //  array('label' => 'Administrar Gastos', 'url' => array('detallegasto/admin')),
                array('label' => 'Estado de Gastos', 'url' => array('detallegasto/estadoGastos')),
                array('label' => 'Matriz de Gastos', 'url' => array('detallegasto/matrizGastos')),
                array('label' => 'Matriz de Gastos Evolucion', 'url' => array('detallegasto/MatrizGastosEvolucion')),
                array('label' => 'Matriz de Nomina', 'url' => array('detallegasto/matrizNomina')),
            );
        }
        /* TESORERO */
        if($tipoUsuario==4)
        {
            return array(
                array('label' => 'Administrar Gastos', 'url' => array('detallegasto/admin')),
            );
        }
        /* SOCIO */
        if($tipoUsuario==5)
        {
            return array(
                array('label' => 'Administrar Gastos', 'url' => array('detallegasto/admin')),
            );
        }
        /* SOCIO */
        if($tipoUsuario==6)
        {
            return array(
                array('label' => 'Estado de Gastos', 'url' => array('detallegasto/estadoGastos')),
            );
        }
    }
}