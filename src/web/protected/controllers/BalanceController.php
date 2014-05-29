<?php
error_reporting(E_ALL & ~E_NOTICE | E_STRICT);
Yii::import('webroot.protected.controllers.LogController');
/**
 * @package controllers
 */
class BalanceController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     * @access public
     */
    public $layout = '//layouts/column2';

    /**
     * @access public
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
     * @access public
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
            array('allow', //Lo que vera el socio
                'actions'=>array(
                    'index',
                    'controlPanel',
                    'admin',
                    'reporteLibroVentas',
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
                    'updateMonto',
                    'reporteLibroVentas',
                    'reporteDepositos',
                    'reporteCaptura',
                    'reporteBrightstar',
                    'index',
                    'guardarExcelBD',
                    'upload',
                    'pop',
                    'view',
                    'viewall',
                    'cicloIngresos',
                    'cicloIngresosTotal',
                    'controlPanel',
                    'subirCaptura',
                    'admin',
                    'EnviarEmail',
                    'update',
                    'excel',
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
                    'updateMonto',
                    'reporteLibroVentas',
                    'reporteDepositos',
                    'reporteCaptura',
                    'reporteBrightstar',
                    'index',
                    'guardarExcelBD',
                    'upload',
                    'pop',
                    'view',
                    'viewall',
                    'cicloIngresos',
                    'cicloIngresosTotal',
                    'controlPanel',
                    'subirCaptura',
                    'admin',
                    'EnviarEmail',
                    'update',
                    'excel'
                ),
                'users'=>array_merge(Users::UsuariosPorTipo(6)),
            ),
            array('allow',
                'actions'=>array(
                    'reporteLibroVentas',
                    'reporteDepositos',
                    'reporteCaptura',
                    'reporteBrightstar',
                    'index',
                    'guardarExcelBD',
                    'upload',
                    'pop',
                    'view',
                    'viewall',
                    'create',
                    'update',
                    'createApertura',
                    'createDeposito',
                    'createLlamadas',
                    'createCierre',
                    'createAperturaEsp',
                    'cicloIngresos',
                    'cicloIngresosTotal',
                    'controlPanel',
                    'upload',
                    'subirCaptura',
                    'admin',
                    'brightstar',
                    'captura',
                    'checkBanco',
                    'mostrarFinal',
                    'updateMonto',
                    'delete',
                    'EnviarEmail',
                    'test',
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
                    'reporteBrightstar',
                    'brightstar',
                    'index',
                    'guardarExcelBD',
                    'upload',
                    'pop',
                    'view',
                    'viewall',
                    'cicloIngresos',
                    'cicloIngresosTotal',
                    'controlPanel',
                    'subirCaptura',
                    'admin',
                    'EnviarEmail',
                    'update',
                    'excel',
                    'UploadFullCarga'
                ),
                'users'=>array_merge(Users::UsuariosPorTipo(2)),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions'=>array(
                    'view',
                    'viewall',
                    'createApertura',
                    'createDeposito',
                    'createLlamadas',
                    'createCierre',
                    'createAperturaEsp',
                    'admin',
                    'EnviarEmail',
                    'excel'
                ),
                'users'=>array_merge(Users::UsuariosPorTipo(1)),
            ),
            array('deny', // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @access public
     * @param integer $id the ID of the model to be displayed
     */
//    public function actionView($id)
//    {
//        $this->render('view', array(
//            'model'=>$this->loadModel($id),
//        ));
//    }

    /**
     * @access public
     */
//    public function actionViewall($id)
//    {
//        $this->render('viewall', array(
//            'model'=>$this->loadModel($id),
//        ));
//    }

    /**
     * @access public
     */
//    public function actionViewReporteLibroVentas($id)
//    {
//        $this->render('viewreporteLibroVentas', array(
//            'model'=>$this->loadModel($id),
//        ));
//    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @access public
     */
//    public function actionCreate()
//    {
//        $model=new Balance;
//        // Uncomment the following line if AJAX validation is needed
//        $this->performAjaxValidation($model);
//
//        if(isset($_POST['Balance']))
//        {
//            $model->attributes=$_POST['Balance'];
//            if($model->save()) $this->redirect(array('view','id'=>$model->Id));
//        }
//        $this->render('create', array(
//            'model'=>$model,
//        ));
//    }

    /**
     * @access public
     */
//    public function actionCreateApertura()
//    {
//        $model=new SaldoCabina;
//        $model->scenario='declararApertura';
//        $this->performAjaxValidation($model);
//        if(isset($_POST['SaldoCabina']))
//        {
//            $cabina=Yii::app()->getModule('user')->user()->CABINA_Id;
//            $list=explode('/', $_POST['SaldoCabina']['Fecha']);
//            $fecha = $list[2]."-".$list[1]."-".$list[0];
//            
//            $balanceExistente = SaldoCabina::model()->find('Fecha=:fecha AND CABINA_Id=:cabina',array(':fecha'=>$fecha,':cabina'=>$cabina));
//            if($balanceExistente!=null)
//            {
//                Yii::app()->user->setFlash('error', "ERROR: Esta Cabina ya tiene un Registro de Apertura para el dia Seleccionado");
//                $this->redirect(array('createApertura'));
//            }
//            else
//            {
//                $model->Fecha = $fecha;
//                $model->SaldoAp = str_replace(',','.',$_POST['SaldoCabina']['SaldoAp']);      
//                $model->COMPANIA_Id = 12;
//                $model->CABINA_Id = $cabina;
//                if($model->save())
//                {
//                    LogController::RegistrarLog(2,$fecha);
//                    $this->redirect(array('admin'));
//                }
//            }
//        }
//        $this->render('createApertura', array(
//            'model'=>$model,
//        ));
//    }
    
    /**
     * @access public
     */
//    public function actionCreateCierre()
//    {
//        $model=new SaldoCabina;
//        $model->scenario='declararApertura';
//        $this->performAjaxValidation($model);
//        if(isset($_POST['SaldoCabina']) && $_POST['SaldoCabina']['SaldoCierre']!=NULL)
//        {
//            $list=explode('/', $_POST['SaldoCabina']['Fecha']);
//            $fecha=$list[2]."-".$list[1]."-".$list[0];
//            $cabina=Yii::app()->getModule('user')->user()->CABINA_Id;
//            $SaldoApertura=SaldoCabina::model()->find('Fecha=:fecha AND SaldoAp>=0 AND CABINA_Id=:cabina', array(':fecha'=>$fecha,':cabina'=>$cabina));
//            if($SaldoApertura->Id!=null)
//            {
//                $SaldoApertura->SaldoCierre = str_replace(',','.',$_POST['SaldoCabina']['SaldoCierre']);
//                if($SaldoApertura->save())
//                {
//                    LogController::RegistrarLog(8,$fecha);
//                    $this->redirect(array('admin'));
//                }
//            }
//            else
//            {
//                Yii::app()->user->setFlash('error', "ERROR: No Existe Balance para la Fecha Indicada");
//                $model=new SaldoCabina;
//                $this->redirect(array('createCierre'));
//            }
//        }
//        $this->render('createCierre', array(
//            'model'=>$model,
//        ));
//    }
    
    /**
     * @access public
     */
//    public function actionCreateLlamadas()
//    {
//        $model=new Detalleingreso;
//        $model->scenario='declararApertura';
//        $model->scenario='declararVentas';
//        
//        
//        $this->performAjaxValidation($model);
//        if(isset($_POST['Detalleingreso']))
//        {
//            $i = 0;
//            $cabina = Yii::app()->getModule('user')->user()->CABINA_Id; 
//            
//            $list=explode('/', $_POST['Detalleingreso']['FechaMes']);
//            $Fecha = $list[2]."-".$list[1]."-".$list[0];
//  
//            if(count($_POST['Detalle'])>0){
//                foreach (array_filter($_POST['Detalle']) as $key => $value) {
//                
//                    $balanceExistente = Detalleingreso::model()->find('FechaMes=:fecha AND CABINA_Id=:cabina AND TIPOINGRESO_Id=:ingreso',
//                                                                array(':fecha'=>$Fecha,':cabina'=>$cabina,':ingreso'=>TipoIngresos::getIdIngreso($key)));
//                    if($balanceExistente==NULL){
//                        $model=new Detalleingreso;
//                        $model->FechaMes = $Fecha; 
//                        $model->Monto = str_replace(',','.',$_POST['Detalle'][$key]); 
//                        $model->moneda = 2; 
//                        $model->USERS_Id = Yii::app()->getModule('user')->user()->id; 
//                        $model->CABINA_Id = $cabina;
//                        $model->TIPOINGRESO_Id = TipoIngresos::getIdIngreso($key); 
//                        if($cabina == 17){
//                            $model->CUENTA_Id = 2;
//                        }else{
//                            $model->CUENTA_Id = 4;
//                        }    
//
//                        $model->save();
//                        $i++;
//                    }
//                }
//            }
//            
//            if($i>0){
//                LogController::RegistrarLog(3,$Fecha);
//                $this->redirect(array('admin'));
//            }else{
//                Yii::app()->user->setFlash('error', "ERROR: La Fecha Indicada ya Posee los Ingresos Declarados");
//                $this->redirect(array('createLlamadas'));
//            }
//        }
//        
//        $this->render('createLlamadas', array(
//            'model'=>$model,
//        ));
//    }

    /**
     * @access public
     */
//    public function actionCreateDeposito()
//    {
//        $model=new Deposito;
//        $model->scenario='declararDeposito';
//
//        // Uncomment the following line if AJAX validation is needed
//        $this->performAjaxValidation($model);
//
//        if(isset($_POST['Deposito']))
//        {
//            
//            $list=explode('/', $_POST['Deposito']['Fecha']);
//            $fechaAux=$list[2]."-".$list[1]."-".$list[0];
//
//            $list2=explode('/', $_POST['Deposito']['FechaCorrespondiente']);
//            $fechaAux2=$list2[2]."-".$list2[1]."-".$list2[0];
//            
//            $cabina = Yii::app()->getModule('user')->user()->CABINA_Id; 
//                
//            $balanceExistente = SaldoCabina::model()->find('Fecha=:fecha AND CABINA_Id=:cabina',array(':fecha'=>$fechaAux2,':cabina'=>$cabina));
//            if($balanceExistente!=null)
//            {
//                $model->attributes = $_POST['Deposito'];
//
//                $model->MontoDep = str_replace(',','.',$_POST['Deposito']['MontoDep']);
//                $model->Fecha = $fechaAux;
//                $model->FechaCorrespondiente = $fechaAux2;
//                $model->Hora=Utility::ChangeTime($_POST['Deposito']['Hora']);
//                $model->CABINA_Id = $cabina;
//                
//                if(isset($_POST['Deposito']['TiempoCierre']) && $_POST['Deposito']['TiempoCierre'] != '')
//                    $model->TiempoCierre = $_POST['Deposito']['TiempoCierre'];
//                
//                if($cabina == 17) 
//                    $model->CUENTA_Id=2;
//                else 
//                    $model->CUENTA_Id=4;
//
//                if($model->save())
//                {
//                    LogController::RegistrarLog(4,$fechaAux);
//                    $this->redirect(array('view','id'=>SaldoCabina::getIdFromDate($fechaAux2,$cabina)));
//                }
//            }
//            else
//            {
//                Yii::app()->user->setFlash('error', "ERROR: No Existe Balance para la Fecha Indicada");
//                $model=new Deposito;
//                $this->redirect(array('createDeposito'));
//            }
//            
//        }
//
//        $this->render('createDeposito', array(
//            'model'=>$model,
//        ));
//    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @access public
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['Balance']))
        {
            $model->attributes=$_POST['Balance'];
            $model->FechaDep =Yii::app()->format->formatDate($_POST['Balance']['FechaDep'],'post');
            
            if($model->CABINA_Id==17) $model->CUENTA_Id=2;
            else $model->CUENTA_Id=4;

            if($model->save()) $this->redirect(array('view','id'=>$model->Id));
        }

        $this->render('update', array(
            'model'=>$model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @access public
     * @param integer $id the ID of the model to be deleted
     */
//    public function actionDelete($id)
//    {
//        $this->loadModel($id)->delete();
//
//        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//        if(!isset($_GET['ajax'])) $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//    }

    /**
     * Lists all models.
     * @access public
     */
    
//    public function actionUploadFullCarga() {
//        
//        $model = new Detalleingreso;
//        $usuario = Yii::app()->getModule('user')->user()->username;
//        
//        if($_POST){
//            Yii::import('ext.phpexcelreader.JPhpExcelReader');
//
//            $fileName1='FullCarga.xls';
//            $ruta1=Yii::getPathOfAlias('webroot.uploads').DIRECTORY_SEPARATOR.$usuario.DIRECTORY_SEPARATOR.$fileName1;
//
//            if(file_exists($ruta1)){
//                $data1=new JPhpExcelReader($ruta1);
//                $data1->saveDB("FullCarga");
//            }elseif(!file_exists($ruta1)){
//                Yii::app()->user->setFlash('error',"No hay Archivos Subidos al Sistema S I N C A.");  
//            }
//        }
//
////        var_dump($_SESSION['cabinas']);
////        echo '<br><br>';
////        var_dump($_SESSION['monto']);
////        echo '<br><br>';
////        echo $_SESSION['fecha'][1];
//
//        
//        $this->render('uploadFullCarga', array(
//            'model'=>$model,
//        ));
//        
//    }
//    
//    public function actionGuardarExcelBD()
//    {
//        Yii::import('ext.phpexcelreader.JPhpExcelReader');
//        $fileName1='claro.xls';
//        $ruta1=Yii::getPathOfAlias('webroot.uploads').DIRECTORY_SEPARATOR.$fileName1;
//        if(file_exists($ruta1))
//        {
//            $data1=new JPhpExcelReader($ruta1);
//            $data1->saveDB("claro");
//        }
//        $fileName2='captura.xls';
//        $fileName2r='captura.XLS';
//        $ruta2=Yii::getPathOfAlias('webroot.uploads').DIRECTORY_SEPARATOR.$fileName2;
//        $ruta2r=Yii::getPathOfAlias('webroot.uploads').DIRECTORY_SEPARATOR.$fileName2r;
//        if(file_exists($ruta2))
//        {
//            $data2=new JPhpExcelReader($ruta2);
//            $data2->saveDB("captura");
//        }
//        elseif(file_exists($ruta2r))
//        {
//            $data2=new JPhpExcelReader($ruta2r);
//            $data2->saveDB("captura");
//        }
//        $fileName3='movistar.xls';
//        $ruta3=Yii::getPathOfAlias('webroot.uploads').DIRECTORY_SEPARATOR.$fileName3;
//        if(file_exists($ruta3))
//        {
//            $data3=new JPhpExcelReader($ruta3);
//            $data3->saveDB("movistar");
//        }
//        $fileName4='etelixPeru.xls';
//        $ruta4=Yii::getPathOfAlias('webroot.uploads').DIRECTORY_SEPARATOR.$fileName4;
//        if(file_exists($ruta4))
//        {
//            $data4=new JPhpExcelReader($ruta4);
//            $data4->saveDB("etelixPeru"); 
//        }
//        if(!file_exists($ruta1) && !file_exists($ruta2) && !file_exists($ruta2r) && !file_exists($ruta3) && !file_exists($ruta4))
//        {
//            Yii::app()->user->setFlash('error',"No hay archivos subidos al sistema S I N C A.");  
//        }
//        if($data1!=null || $data2!=null || $data3!=null || $data4!=null)
//        {
//            Yii::app()->user->setFlash('success',"Se han cargado los Datos con exito");
//        }
//        $this->redirect('index');
//    }
//
//    /**
//     * @access public
//     */
//    public function actionUpload()
//    {
//        Yii::import("ext.EAjaxUpload.qqFileUploader");
//        
//        $usuario = Yii::app()->getModule('user')->user()->username;
//        $carpetaUsuario = Yii::getPathOfAlias('webroot.uploads').DIRECTORY_SEPARATOR;
//
//        Users::createFolderUser($carpetaUsuario,$usuario);
//
//        $folder=$carpetaUsuario.$usuario.DIRECTORY_SEPARATOR;// folder for uploaded files
//        $allowedExtensions=array("xls","XLS");//array("jpg","jpeg","gif","exe","mov" and etc...
//        $sizeLimit=1*1024*1024;// maximum file size in bytes
//        $uploader=new qqFileUploader($allowedExtensions, $sizeLimit);
//        $result=$uploader->handleUpload($folder);
//        $return=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
//        
//        $fileSize=filesize($folder . $result['filename']); //GETTING FILE SIZE
//        $fileName=$result['filename']; //GETTING FILE NAME
//
//        echo $return; // it's array
//    }

    /**
     * @access public
     */
//    public function actionIndex()
//    {
//        $modelo=new Balance;
//        $dataProvider=new CActiveDataProvider('Balance');
//        $this->render('index', array(
//            'dataProvider'=>$dataProvider,
//        ));
//    }

    /**
     * @access public
     */
    public function actionBrightstar()
    {
        $model=new Balance;
        $model->scenario='declararBrightstar';
        $modellog=new Log;
        $fecha=time();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['Balance']))
        {
            $model->attributes=$_POST['Balance'];
            $model->FechaIngresoLlamadas=date("Y-m-d H:i:s", $fecha);
            $fechaAux=$model->Fecha;
            $list=explode('/', $fechaAux);
            $fechaAux=$list[2]."-".$list[1]."-".$list[0];
            //BUSCO EN BD EL REGISTRO QUE COINCIDA CON LA DATA
            $sql="SELECT id 
                  FROM balance
                  WHERE Fecha=:fecha AND CABINA_Id=:cabina";
            $connection=Yii::app()->db;
            $command=$connection->createCommand($sql);
            $command->bindValue(":cabina", $model->CABINA_Id, PDO::PARAM_INT); // bind de parametro cabina del user
            $command->bindValue(":fecha", $fechaAux, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
            $id=$command->query(); // execute a query SQL
            //BUSCO LOS VALORES Y EL REGISTRO A ACTUALIZAR
            $post=$model->findByPk($id->readColumn(0));
            if(is_null($post->Id))
            {
                Yii::app()->user->setFlash('error', "ERROR: No Existe Balance para la Fecha Indicada");
            }
            else
            {
                $post->RecargaVentasMov=$model->RecargaVentasMov;
                $post->RecargaVentasClaro=$model->RecargaVentasClaro;
                if($post->save() && $modellog->save()) Yii::app()->user->setFlash('success', "**");
                $this->redirect(array('viewall', 'id'=>$post->Id));
            }
        }
        $this->render('brightstar', array(
            'model'=>$model,
        ));
    }
    

    /**
     *
     */
    public function actionCaptura()
    {
        $model=new Balance;
        $model->scenario='declararCaptura';
        $modellog=new Log;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['Balance']))
        {
            $model->attributes=$_POST['Balance'];
            $fechaAux=$model->Fecha;
            $list=explode('/', $fechaAux);
            $fechaAux=$list[2]."-".$list[1]."-".$list[0];
            //BUSCO EN BD EL REGISTRO QUE COINCIDA CON LA DATA
            $sql="SELECT id 
                  FROM balance 
                  WHERE Fecha=:fecha AND CABINA_Id=:cabina";
            $connection=Yii::app()->db;
            $command=$connection->createCommand($sql);
            $command->bindValue(":cabina", $model->CABINA_Id, PDO::PARAM_INT); // bind de parametro cabina del user
            $command->bindValue(":fecha", $fechaAux, PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
            $id=$command->query(); // execute a query SQL
            //BUSCO LOS VALORES Y EL REGISTRO A ACTUALIZAR
            $post=$model->findByPk($id->readColumn(0));
            if(is_null($post->Id))
            {
                Yii::app()->user->setFlash('error', "ERROR: No Existe Balance para la Cabina indicada en la Fecha Indicada");
            }
            else
            {
                $post->TraficoCapturaDollar=$model->TraficoCapturaDollar;
                if($post->save() && $modellog->save()) Yii::app()->user->setFlash('success', "**");
                $this->redirect(array('viewall', 'id'=>$post->Id));
            }
        }
        $this->render('captura', array(
            'model'=>$model,
        ));
    }

    /**
     * Manages all models.
     * @access public
     */
//    public function actionAdmin()
//    {
//        $model=new SaldoCabina('search');
//        $model->unsetAttributes();  // clear any default values
//        if(isset($_GET['SaldoCabina'])) $model->attributes=$_GET['SaldoCabina'];
//
//        $this->render('admin', array(
//            'model'=>$model,
//        ));
//    }

    /**
     * @access public
     */
//    public function actionControlPanel()
//    {
//        $model=new Log('search');
//        $model->unsetAttributes();  // clear any default values
//        if (isset($_GET['Log'])) $model->attributes=$_GET['Log'];
//
//        $this->render('controlPanel', array(
//            'model'=>$model,
//        ));
//    }
    
    /**
     * @access public
     */
    public function actionCicloIngresos()
    {
        $model=new SaldoCabina('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['SaldoCabina'])) $model->attributes=$_GET['SaldoCabina'];

        $this->render('cicloIngresos', array(
            'model'=>$model,
        ));
    }
    
    /**
     * @access public
     */
    public function actioncicloIngresosTotal()
    {
        $model=new Balance('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Balance'])) $model->attributes=$_GET['Balance'];
        $this->render('cicloIngresosTotal', array(
            'model'=>$model,
        ));
    }

    /**
     * @access public
     */
    public function actionPop($id)
    {
        $model=new Balance('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Balance'])) $model->attributes = $_GET['Balance'];
        switch($id)
        {
            case '1':
                $this->render('_reporteLibroVentas', array(
                    'model'=>$model,
                ));
                break;
            case '2':
                $this->render('_reporteDepositosBancarios', array(
                    'model'=>$model,
                ));
                break;
            case '3':
                $this->render('_reporteBrightstar', array(
                    'model'=>$model,
                ));
                break;
            case '4':
                $this->render('_reporteCaptura', array(
                    'model'=>$model,
                ));
                break;
            case '5':
                $this->render('_disLibroVentas', array(
                    'model'=>$model,
                ));
                break;
            case '6':
                $this->render('_disDepositos', array(
                    'model'=>$model,
                ));
                break;
            case '7':
                $this->render('_disBrightstar', array(
                    'model'=>$model,
                ));
                break;
            case '8':
                $this->render('_disCaptura', array(
                    'model'=>$model,
                ));
                break;
        }
    }

    /**
     * @access public
     */
//    public function actionReporteLibroVentas()
//    {
//        $model=new SaldoCabina('search');
//        $model->unsetAttributes();  // clear any default values
//        if(isset($_GET['SaldoCabina'])) $model->attributes=$_GET['SaldoCabina'];
//
//        $this->render('reporteLibroVentas', array(
//            'model'=>$model,
//        ));
//    }
    
    /**
     * @access public
     */
    public function actionReporteBrightstar()
    {
        $model=new Balance('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Balance'])) $model->attributes = $_GET['Balance'];

        $this->render('reporteBrightstar', array(
            'model'=>$model,
        ));
    }
    
    /**
     * @access public
     */
    public function actionReporteCaptura()
    {
        $model=new Balance('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Balance'])) $model->attributes=$_GET['Balance'];

        $this->render('reporteCaptura', array(
            'model'=>$model,
            )
        );
    }
    
    /**
     * @access public
     */
//    public function actionReporteDepositos()
//    {
//        $model=new Deposito('search');
//        $model->unsetAttributes();  // clear any default values
//        if(isset($_GET['Deposito'])) $model->attributes=$_GET['Deposito'];
//
//        $this->render('reporteDepositos', array(
//            'model'=>$model,
//        ));
//    }
    
    /**
     * @access public
     */
//    public function actionMostrarFinal()
//    {
//        $model=new Deposito('search');
//        $model->unsetAttributes();  // clear any default values
//        if(isset($_GET['Deposito'])) $model->attributes = $_GET['Deposito'];
//        $this->render('mostrarFinal', array(
//            'model'=>$model,
//        ));
//    }

    /**
     * @access public
     */
//    public function actionCheckBanco()
//    {
//        $model = new Deposito('search');
//        $model->unsetAttributes();  // clear any default values
//        if(isset($_GET['Deposito'])) $model->attributes=$_GET['Deposito'];
//
//        $this->render('checkBanco', array(
//            'model'=>$model,
//        ));
//    }

    /**
     * @access public
     */
//    public function actionUpdateMonto()
//    {
//        $idBalancesActualizados="";
//        
//        //creo el parametro de busqueda
//        $criteria=new CDbCriteria();
//        $criteria->addCondition('MontoBanco IS NULL'); //busco solo los registros que MontoBanco sea NULL
//        $criteria->addCondition('MontoDep IS NOT NULL'); //busco solo los registros que MontoDeposito no sea NULL
//        //instancio el modelo
//        $model=Deposito::model()->find($criteria);
//        //asigno el id para usarlo luego
//        $id=$model->id;
//        while($model->id!=null)
//        {
//            if(isset($_POST['MontoBanco'.$id]) && $_POST['MontoBanco'.$id]!=null && is_numeric($_POST['MontoBanco'.$id]))
//            {
//                
//                $model->MontoBanco=$_POST['MontoBanco'.$id];
//                if($model->CABINA_Id==17)
//                {
//                    $model->CUENTA_Id=2;
//                }
//                else
//                {
//                    $model->CUENTA_Id=4;
//                }
//                
//                $modelCicloIngreso = CicloIngresoModelo::model()->find("Fecha = '$model->FechaCorrespondiente' AND CABINA_Id = $model->CABINA_Id");
//                if($modelCicloIngreso == NULL){
//                    $modelCicloIngreso = new CicloIngresoModelo;
//                    $modelCicloIngreso->Fecha = $model->FechaCorrespondiente;
//                    $modelCicloIngreso->CABINA_Id = $model->CABINA_Id;
//                    $modelCicloIngreso->ConciliacionBancaria = round(($_POST['MontoBanco'.$id]-$model->MontoDep),2);
//                    $modelCicloIngreso->DiferencialBancario = round(($_POST['MontoBanco'.$id]-Detalleingreso::getLibroVentas("LibroVentas","TotalVentas", $model->FechaCorrespondiente, $model->CABINA_Id)),2);
//                    $modelCicloIngreso->save();
//
//                    if($model->save())
//                    {
//                        $idBalancesActualizados.=$model->id.'A';
//                        $model=Deposito::model()->find($criteria);
//                        $id=$model->id;
//                    }
//                }    
//            }
//            else
//            {
//                $criteria->addCondition('id > '.$id);
//                $model=Deposito::model()->find($criteria);
//                $id=$model->id;
//            }
//        }
//        $this->redirect(array('mostrarFinal','id'=>$model->id,'idBalancesActualizados'=>$idBalancesActualizados)); 
//    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Balance the loaded model
     * @throws CHttpException
     */
//    public function loadModel($id)
//    {
//        $model=  SaldoCabina::model()->findByPk($id);
//        if ($model===null) throw new CHttpException(404, 'The requested page does not exist.');
//        return $model;
//    }

    /**
     * Performs the AJAX validation.
     * @param Balance $model the model to be validated
     */
//    protected function performAjaxValidation($model) 
//    {
//        if(isset($_POST['ajax']) && $_POST['ajax']==='balance-form')
//        {
//            echo CActiveForm::validate($model);
//            Yii::app()->end();
//        }
//    }
    
    /**
     * @access public
     */
//    public function actionEnviarEmail()
//    {
//        Yii::app()->correo->SendEmail($_POST['vista'],$_POST['correoUsuario'],$_POST['asunto']);
//        $this->redirect($_POST['vista']);
//    }

    /**
     * @access public
     */
//    public static function controlAcceso($tipoUsuario)
//    {
//        //OPERADOR DE CABINA
//        if($tipoUsuario==1)
//        {
//            return array(
//                    array('label'=>'Declarar Inicio Jornada','url'=>array('log/createInicioJornada')),
//                    array('label'=>'Declarar Saldo Apertura','url'=>array('saldocabina/createApertura')),
//                    array('label'=>'Declarar Ventas','url'=>array('detalleingreso/createLlamadas')),
//                    array('label'=>'Declarar Deposito','url'=>array('deposito/createDeposito')),
//                    array('label'=>'Declarar Saldo Cierre','url'=>array('saldocabina/createCierre')),
//                    array('label'=>'Declarar Fin Jornada','url'=>array('log/createFinJornada')),
//                    array('label'=>'Mostrar Balances de Cabina','url'=>array('detalleingreso/adminBalance')),
//                );
//        }
//        //GERENTE DE OPERACIONES
//        if($tipoUsuario==2)
//        {
//            return array(
//                array('label'=>'Cargar data FullCarga y SORI','url'=>array('balance/uploadFullCarga')),
////                array('label'=>'Ingresar Datos Brightstar','url'=>array('balance/brightstar')),
////                array('label'=>'Ingresar Datos Captura','url'=>array('balance/captura')),
//                array('label'=>'__________REPORTES___________','url'=>array('')),
//                array('label'=>'Reporte Libro Ventas','url'=>array('balance/reporteLibroVentas')),
//                array('label'=>'Reporte Depositos Bancarios','url'=>array('balance/reporteDepositos')),
//                array('label'=>'Reporte Brightstar','url'=>array('balance/reporteBrightstar')),
//                array('label'=>'Reporte Captura','url'=>array('balance/reporteCaptura')),
//                array('label'=>'Reporte Ciclo de Ingresos','url'=>array('balance/cicloIngresos')),
//                array('label'=>'Reporte Ciclo de Ingresos Total','url'=>array('balance/cicloIngresosTotal')),
//                array('label'=>'_____________________________','url' => array('')),
//                array('label'=>'Administrar Balances','url'=>array('balance/admin')),
//                array('label'=>'Horarios Cabina','url'=>array('cabina/admin')),
//                array('label'=>'Tablero de Control de Actv.','url'=>array('balance/controlPanel')),
//                );
//        }
//        //ADMINISTRADOR 
//        if($tipoUsuario==3)
//        {
//            return array(
//                array('label'=>'Tablero de Control de Actv.','url'=>array('log/controlPanel')),
//                array('label'=>'Administrar Balances','url'=>array('balance/admin')),
//                array('label'=>'Horarios Cabina','url'=>array('cabina/admin')),
//                array('label'=>'__________REPORTES___________','url'=>array('')),
//                array('label'=>'Reporte Libro Ventas','url'=>array('balance/reporteLibroVentas')),
//                array('label'=>'Reporte Depositos Bancarios','url'=>array('deposito/reporteDepositos')),
//                array('label'=>'Reporte Brightstar','url'=>array('balance/reporteBrightstar')),
//                array('label'=>'Reporte Captura','url'=>array('balance/reporteCaptura')),
//                array('label'=>'Reporte Ciclo de Ingresos','url'=>array('balance/cicloIngresos')),
//                array('label'=>'Reporte Ciclo de Ingresos Total','url'=>array('balance/cicloIngresosTotal')),
//                );
//        }
//        //TESORERO
//        if($tipoUsuario==4)
//        {
//            return array(
//                array('label'=>'Reporte Libro Ventas','url'=>array('balance/reporteLibroVentas')),
//                array('label'=>'Reporte Depositos Bancarios','url'=>array('balance/reporteDepositos')),
//                array('label'=>'Reporte Brightstar','url'=>array('balance/reporteBrightstar')),
//                array('label'=>'Reporte Captura','url'=>array('balance/reporteCaptura')),
//                array('label'=>'Reporte Ciclo de Ingresos','url'=>array('balance/cicloIngresos')),
//                array('label'=>'Reporte Ciclo de Ingresos Total','url'=>array('balance/cicloIngresosTotal')),
//                array('label'=>'_____________________________','url'=>array('')),
//                array('label'=>'Administrar Balances','url'=>array('balance/admin')),
//                array('label'=>'Tablero de Control de Actv.','url'=>array('balance/controlPanel')),
//                array('label'=>'Horarios Cabina','url'=>array('cabina/admin')),
//                );
//        }
//        //SOCIO
//        if($tipoUsuario==5)
//        {
//            return array(
//                array('label'=>'Tablero de Control de Actv.','url'=>array('balance/controlPanel')),
//                array('label'=>'Administrar Balances','url'=>array('balance/admin')),
//                array('label'=>'Horarios Cabina','url'=>array('cabina/admin')),
//                array('label'=>'__________REPORTES___________','url'=>array('')),
//                array('label'=>'Reporte Libro Ventas','url'=>array('balance/reporteLibroVentas')),
//                array('label'=>'Reporte Depositos Bancarios','url'=>array('balance/reporteDepositos')),
//                array('label'=>'Reporte Brightstar','url'=>array('balance/reporteBrightstar')),
//                array('label'=>'Reporte Captura','url'=>array('balance/reporteCaptura')),
//                array('label'=>'Reporte Ciclo de Ingresos','url'=>array('balance/cicloIngresos')),
//                array('label'=>'Reporte Ciclo de Ingresos Total','url'=>array('balance/cicloIngresosTotal')),
//                );
//        }
//        //GERENTE CONTABILIDAD
//        if($tipoUsuario==6)
//        {
//            return array(
//                array('label'=>'Tablero de Control de Actv.','url'=>array('balance/controlPanel')),
//                array('label'=>'Administrar Balances','url'=>array('balance/admin')),
//                array('label'=>'__________REPORTES___________','url'=>array('')),
//                array('label'=>'Reporte Libro Ventas','url'=>array('balance/reporteLibroVentas')),
//                array('label'=>'Reporte Depositos Bancarios','url'=>array('balance/reporteDepositos')),
//                array('label'=>'Reporte Brightstar','url'=>array('balance/reporteBrightstar')),
//                array('label'=>'Reporte Captura','url'=>array('balance/reporteCaptura')),
//                array('label'=>'Reporte Ciclo de Ingresos','url'=>array('balance/cicloIngresos')),
//                array('label'=>'Reporte Ciclo de Ingresos Total','url'=>array('balance/cicloIngresosTotal')),
//                );
//        }
//    }

    /**
     * @access public
     */
    public static function getHeader($compania=null)
    {
        if($compania==null || $compania=="movistar")
        {
            return "Movistar";
        }
        elseif($compania=="claro")
        {
            return "Claro";
        }
    }
}
