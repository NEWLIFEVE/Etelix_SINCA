<?php
Yii::import('webroot.protected.modules.user.models.User');
/**
 *
 */
class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     * @access public
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
                ),
                // page action renders "static" pages stored under 'protected/views/site/pages'
                // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
                ),
            );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     * @access public
     */
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     * @access public
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest) echo $error['message'];
            else $this->render('error', $error);
        }
    }

    /**
     * @access public
     */
    public function actionSessionFinished()
    {
        $this->render('sessionFinished','');
    }

    /**
     * Displays the contact page
     * @access public
     */
    public function actionContact()
    {
        $model=new ContactForm;
        if(isset($_POST['ContactForm']))
        {
            $model->attributes=$_POST['ContactForm'];
            if($model->validate())
            {
                $name='=?UTF-8?B?'.base64_encode($model->name).'?=';
                $subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
                $headers="From: $name <{$model->email}>\r\n".
                         "Reply-To: {$model->email}\r\n".
                         "MIME-Version: 1.0\r\n".
                         "Content-type: text/plain; charset=UTF-8";
                mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact',array('model'=>$model));
    }

    /**
     * Displays the login page
     * @access public
     */
    public function actionLogin()
    {
        $model=new LoginForm;
        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()) $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     * @access public
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * @access public
     */
    public static function actionMail()
    {
        $mailer=new EnviarEmail;
    }
   
    /**
     * Esta funcion se encarga de devolver el arreglo con el Menu del sistema dependiendo del tipo de usuario
     * @access public
     * @static
     */
    public static function controlAcceso($tipoUsuario)
    {
        $idUsuario=Yii::app()->user->id;
        /* OPERADOR DE CABINA */
        if($tipoUsuario==1)
        {
            return array(
                array('url'=>Yii::app()->getModule('user')->loginUrl,'label'=>Yii::app()->getModule('user')->t("Login"),'visible'=>Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->registrationUrl,'label'=>Yii::app()->getModule('user')->t("Register"),'visible'=>Yii::app()->user->isGuest),
                array('url'=>array('/log/createInicioJornada'),'label'=>'Declarar','visible'=>!Yii::app()->user->isGuest),
                array('url'=>array('/novedad/create'),'label'=>'Novedades/Fallas','visible'=>!Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->logoutUrl,'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->getModule('user')->user($idUsuario)->username.'/'.Cabina::getNombreCabina(Yii::app()->getModule('user')->user($idUsuario)->CABINA_Id).')','visible'=>!Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->profileUrl,'label'=>Yii::app()->getModule('user')->t("Profile"),'visible'=>!Yii::app()->user->isGuest),
                );
        }
        /* GERENTE DE OPERACIONES */
        if($tipoUsuario==2)
        {
            return array(
                array('url'=>Yii::app()->getModule('user')->loginUrl,'label'=>Yii::app()->getModule('user')->t("Login"),'visible'=>Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->registrationUrl,'label'=>Yii::app()->getModule('user')->t("Register"),'visible'=>Yii::app()->user->isGuest),
                array('url'=>array('/balance/index'),'label'=>'Reportes/Balances','visible'=>!Yii::app()->user->isGuest),
                array('url'=>array('/pabrightstar/create'),'label'=>'P.A.B.','visible'=>!Yii::app()->user->isGuest),
                array('url'=>array('/detallegasto/create'),'label'=>'Gastos','visible'=>!Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->logoutUrl,'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->getModule('user')->user($idUsuario)->username.'/GerenteOp)','visible'=>!Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->profileUrl,'label'=>Yii::app()->getModule('user')->t("Profile"),'visible'=>!Yii::app()->user->isGuest),
                );
        }
        /* ADMINISTRADOR */
        if($tipoUsuario==3)
        {
            return array(
                array('url'=>Yii::app()->getModule('user')->loginUrl,'label'=>Yii::app()->getModule('user')->t("Login"),'visible'=>Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->registrationUrl,'label'=>Yii::app()->getModule('user')->t("Register"),'visible'=>Yii::app()->user->isGuest),
                array('url'=>array('/balance/controlPanel'),'label'=>'Balances','visible'=>!Yii::app()->user->isGuest),
                array('url'=>array('/pabrightstar/admin'),'label'=>'P.A.B.','visible'=>!Yii::app()->user->isGuest),
                array('url'=>array('/detallegasto/estadoGastos'),'label'=>'Gastos','visible'=>!Yii::app()->user->isGuest),
                array('url'=>array('/novedad/admin'),'label'=>'Novedades/Fallas','visible'=>!Yii::app()->user->isGuest),
                array('url'=>array('/log/admin'),'label'=>'Log','visible'=>!Yii::app()->user->isGuest),
                array('url' => array('/nomina/adminEmpleado'), 'label' => 'Nomina', 'visible' => !Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->logoutUrl,'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->getModule('user')->user($idUsuario)->username.'/Admin)','visible'=>!Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->profileUrl,'label'=>Yii::app()->getModule('user')->t("Profile"),'visible'=>!Yii::app()->user->isGuest),
                );
        }
        /* TESORERO */
        if($tipoUsuario==4)
        {
            return array(
                array('url'=>Yii::app()->getModule('user')->loginUrl,'label'=>Yii::app()->getModule('user')->t("Login"),'visible'=>Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->registrationUrl,'label'=>Yii::app()->getModule('user')->t("Register"),'visible'=>Yii::app()->user->isGuest),
                array('url'=>array('/balance/reporteDepositos'),'label'=>'Reportes','visible'=>!Yii::app()->user->isGuest),
                array('url'=>array('/paridad/create'),'label'=>'Banco/Tesoreria','visible'=>!Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->logoutUrl,'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->getModule('user')->user($idUsuario)->username.'/Tesorero)','visible'=>!Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->profileUrl,'label'=>Yii::app()->getModule('user')->t("Profile"),'visible'=>!Yii::app()->user->isGuest),
                );
        }
        /* SOCIO */
        if($tipoUsuario==5)
        {
            return array(
                array('url'=>Yii::app()->getModule('user')->loginUrl,'label'=>Yii::app()->getModule('user')->t("Login"),'visible'=>Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->registrationUrl,'label'=>Yii::app()->getModule('user')->t("Register"),'visible'=>Yii::app()->user->isGuest),
                array('url'=>array('/balance/controlPanel'),'label'=>'Reportes','visible'=>!Yii::app()->user->isGuest),
                array('url'=>array('/pabrightstar/admin'),'label'=>'P.A.B.','visible'=>!Yii::app()->user->isGuest),
                array('url'=>array('/novedad/admin'),'label'=>'Novedades/Fallas','visible'=>!Yii::app()->user->isGuest),
                array('url'=>array('/log/admin'),'label'=>'Log','visible'=>!Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->logoutUrl,'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->getModule('user')->user($idUsuario)->username.'/Socio)','visible'=>!Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->profileUrl,'label'=>Yii::app()->getModule('user')->t("Profile"),'visible'=>!Yii::app()->user->isGuest),
                );
        }
        /* GERENTE DE CONTABILIDAD */
        if($tipoUsuario==6)
        {
            return array(
                array('url'=>Yii::app()->getModule('user')->loginUrl,'label'=>Yii::app()->getModule('user')->t("Login"),'visible'=>Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->registrationUrl,'label'=>Yii::app()->getModule('user')->t("Register"),'visible'=>Yii::app()->user->isGuest),
                array('url'=>array('/balance/controlPanel'),'label'=>'Reportes','visible'=>!Yii::app()->user->isGuest),
                array('url'=>array('/detallegasto/estadoGastos'),'label'=>'Gastos','visible'=>!Yii::app()->user->isGuest), 
                array('url'=>array('/pabrightstar/admin'),'label'=>'P.A.B.','visible'=>!Yii::app()->user->isGuest), 
                array('url'=>Yii::app()->getModule('user')->logoutUrl,'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->getModule('user')->user($idUsuario)->username.'/GerenteCont)','visible'=>!Yii::app()->user->isGuest),
                array('url'=>Yii::app()->getModule('user')->profileUrl,'label'=>Yii::app()->getModule('user')->t("Profile"),'visible'=>!Yii::app()->user->isGuest),
                );
        }
        /* RRHH */
        if ($tipoUsuario == 7)
        {
            return array(
                //array('label' => 'Home', 'url' => array('/site/index')),
                array('url' => Yii::app()->getModule('user')->loginUrl, 'label' => Yii::app()->getModule('user')->t("Login"), 'visible' => Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->registrationUrl, 'label' => Yii::app()->getModule('user')->t("Register"), 'visible' => Yii::app()->user->isGuest),
                array('url' => array('/nomina/adminEmpleado'), 'label' => 'Nomina', 'visible' => !Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->logoutUrl, 'label' => Yii::app()->getModule('user')->t("Logout") . ' (' . Yii::app()->getModule('user')->user($idUsuario)->username . '/RRHH)', 'visible' => !Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->profileUrl, 'label' => Yii::app()->getModule('user')->t("Profile"), 'visible' => !Yii::app()->user->isGuest),
            
            );
        }
    }

    /**
     * @access public
     * @static
     */
    public static function mensajesConfirm($tipo)
    {
        switch($tipo)
        {
            case 1:
                return '¿Está Seguro de los Montos Declarados? (Esta declaración es irreversible)';
                break;
            case 2:
                return '¿Está Seguro de la Hora de Inicio de Jornada Laboral?';
                break;
            case 3:
                return '¿Está Seguro de la Hora de Fin de Jornada Laboral?';
                break;
            case 4:
                return '¿Está Seguro que desea Actualizar este Balance?';
                break;
            case 5:
                return '¿Está Seguro que desea Actualizar la Paridad Cambiaria?';
                break;
            case 6:
                return '¿Está Seguro que desea Actualizar la Comision Brightstar para esta Compania?';
                break;
            case 7:
                return '¿Está Seguro que desea Recargar la Cantidad indicada a la Cabina indicada?';
                break;
        }
    }
    
    /**
     * ACCIONES PARA EXPORTAR A EXCEL, ENVIAR CORREO ELECTRONICO E IMPIRMIR (LLAMAN A LAS FUNCIONES CORRESPONDIENTES)
     * @access public
     */
    public function actionExcel()
    {
        $files=array();
        if($_GET['table']=='balance-grid' || $_GET['table']=='balance-grid-oculta')
        {
            $files['balance']['name']=$_GET['name'];
            $files['balance']['body']=Yii::app()->reporte->balanceAdmin($_GET['ids'],$_GET['name'],true);
        }
        if($_GET['table']=='balanceLibroVentas' || $_GET['table']=='balanceLibroVentasOculta')
        {
            $files['libroVentas']['name']=$_GET['name'];
            $files['libroVentas']['body']=Yii::app()->reporte->libroVenta($_GET['ids'],$_GET['name'],true);
        }
        if($_GET['table']=='balanceReporteDepositos' || $_GET['table']=='balanceReporteDepositosOculta')
        {
            $files['depositoBancario']['name']=$_GET['name'];
            $files['depositoBancario']['body']=Yii::app()->reporte->depositoBancario($_GET['ids'],$_GET['name'],true);
        }
        if($_GET['table']=='balanceReporteBrighstar' || $_GET['table']=='balanceReporteBrighstarOculta')
        {
            $files['ventasbrighstar']['name']=$_GET['name'];
            $files['ventasbrighstar']['body']=Yii::app()->reporte->brightstar($_GET['ids'],$_GET['name'],true);
        }
        if($_GET['table']=='balanceReporteCaptura' || $_GET['table']=='balanceReporteCapturaOculta')
        {
            $files['traficocaptura']['name']=$_GET['name'];
            $files['traficocaptura']['body']=Yii::app()->reporte->captura($_GET['ids'],$_GET['name'],true);
        }
        if($_GET['table']=='balanceCicloIngresosResumido' || $_GET['table']=='balanceCicloIngresosResumidoOculta')
        {
            $files['cicloIngreso']['name']=$_GET['name'];
            $files['cicloIngreso']['body']=Yii::app()->reporte->cicloIngreso($_GET['ids'],$_GET['name'],false,true);
        }
        if($_GET['table']=='balanceCicloIngresosCompletoActivas' || $_GET['table']=='balanceCicloIngresosCompletoInactivas')
        {
            $files['cicloIngresoC']['name']=$_GET['name'];
            $files['cicloIngresoC']['body']=Yii::app()->reporte->cicloIngreso($_GET['ids'],$_GET['name'],true,true);
        }
        if($_GET['table']=='balanceCicloIngresosTotalResumido' || $_GET['table']=='balanceCicloIngresosTotalResumidoOculta')
        {
            $files['cicloIngresoT']['name']=$_GET['name'];
            $files['cicloIngresoT']['body']=Yii::app()->reporte->cicloIngresoTotal($_GET['ids'],$_GET['name'],false,true);
        }
        if($_GET['table']=='balanceLibroVentas' || $_GET['table']=='balanceLibroVentasOculta')
        {
            $files['libroVentas']['name']=$_GET['name'];
            $files['libroVentas']['body']=Yii::app()->reporte->libroVenta($_GET['ids'],$_GET['name'],true);
        }
        if($_GET['table']=='balanceReporteDepositos' || $_GET['table']=='balanceReporteDepositosOculta')
        {
            $files['depositoBancario']['name']=$_GET['name'];
            $files['depositoBancario']['body']=Yii::app()->reporte->depositoBancario($_GET['ids'],$_GET['name'],true);
        }
        if($_GET['table']=='balanceReporteBrighstar' || $_GET['table']=='balanceReporteBrighstarOculta')
        {
            $files['ventasbrighstar']['name']=$_GET['name'];
            $files['ventasbrighstar']['body']=Yii::app()->reporte->brightstar($_GET['ids'],$_GET['name'],true);
        }
        if($_GET['table']=='balanceReporteCaptura' || $_GET['table']=='balanceReporteCapturaOculta')
        {
            $files['traficocaptura']['name']=$_GET['name'];
            $files['traficocaptura']['body']=Yii::app()->reporte->captura($_GET['ids'],$_GET['name'],true);
        }
        if($_GET['table']=='balanceCicloIngresosResumido' || $_GET['table']=='balanceCicloIngresosResumidoOculta')
        {
            $files['cicloIngreso']['name']=$_GET['name'];
            $files['cicloIngreso']['body']=Yii::app()->reporte->cicloIngreso($_GET['ids'],$_GET['name'],false,true);   
        }
        if($_GET['table']=='balanceCicloIngresosCompleto')
        {
            $files['cicloIngresoC']['name']=$_GET['name'];
            $files['cicloIngresoC']['body']=Yii::app()->reporte->cicloIngreso($_GET['ids'],$_GET['name'],true,true);  
        }
        if($_GET['table']=='balanceCicloIngresosTotalResumido' || $_GET['table']=='balanceCicloIngresosTotalResumidoOculta')
        {
            $files['cicloIngresoT']['name']=$_GET['name'];
            $files['cicloIngresoT']['body']=Yii::app()->reporte->cicloIngresoTotal($_GET['ids'],$_GET['name'],false,true);
        }
        if($_GET['table']=='tabla')
        {
            $files['matriz']['name']=$_GET['name'];
            $files['matriz']['body']=Yii::app()->reporte->matrizGastos($_GET['mes'],$_GET['name'],true);
        }
        if($_GET['table']=='tabla2'){
            $files['matrizE']['name']=$_GET['name'];
            $files['matrizE']['body']=Yii::app()->reporte->matrizGastosEvolucion($_GET['mes'],$_GET['cabina'],$_GET['name'],true);
        }
        if($_GET['table']=='tabla3')
        {
            $files['TableroA']['name']=$_GET['name'];
            $files['TableroA']['body']=Yii::app()->reporte->tableroControl($_GET['date'],$_GET['name']);
        }
        if($_GET['table']=='estadogasto-grid')
        {
            $files['estadogasto']['name']=$_GET['name'];
            $files['estadogasto']['body']=Yii::app()->reporte->estadoGasto($_GET['ids'],$_GET['name'],true);
        }
        if($_GET['table']=='novedad-grid')
        {
            $files['novedadF']['name']=$_GET['name'];
            $files['novedadF']['body']=Yii::app()->reporte->novedadFalla($_GET['ids'],$_GET['name']);              
        }
        if($_GET['table']=='employee-grid')
        {
            $files['nominaE']['name']=$_GET['name'];
            $files['nominaE']['body']=Yii::app()->reporte->nominaEmpleado($_GET['ids'],$_GET['name']);              
        }
        if($_GET['table']=='log-grid')
        {
            $files['logs']['name']=$_GET['name'];
            $files['logs']['body']=Yii::app()->reporte->logs($_GET['ids'],$_GET['name']);            
        }
        if($_GET['table']=='reportePaBrightstar')
        {
            $files['PaBrightstar']['name']=$_GET['name'];
            $files['PaBrightstar']['body']=Yii::app()->reporte->pabrightstarReport($_GET['ids'],$_GET['name'],true);         
        }
        if($_GET['table']=='tablaNomina')
        {
            $files['MatrizNo']['name']=$_GET['name'];
            $files['MatrizNo']['body']=Yii::app()->reporte->matrizNomina($_GET['mes'],$_GET['name'],true);             
        }
        if($_GET['table']=='cabina-grid')
        {
            $files['HorarioC']['name']=$_GET['name'];
            $files['HorarioC']['body']=Yii::app()->reporte->horarioCabina($_GET['ids'],$_GET['name']);          
        }
        if($_GET['table']=='banco-grid')
        {
            $files['AbminBanco']['name']=$_GET['name'];
            $files['AbminBanco']['body']=Yii::app()->reporte->adminBanco($_GET['ids'],$_GET['name'],true);           
        }
        if($_GET['table']=='DetailretesoMov')
        {
            $files['retesoMov']['name']=$_GET['name'];
            $files['retesoMov']['body']=Yii::app()->reporte->retesoMovimiento($_GET['ids'],$_GET['name'],true);
        }
        
        foreach($files as $key => $file)
        {
            $this->genExcel($file['name'],$file['body'],true);
        }
    }
    
    /**
     * @access public
     */
    public function actionSendEmail()
    {
        $correo=Yii::app()->getModule('user')->user()->email;
        $topic=$_GET['name'];    
        $files=array();
        if($_GET['table']=='balance-grid' || $_GET['table']=='balance-grid-oculta')
        {
            $files['balance']['name']=$_GET['name'];
            $files['balance']['body']=Yii::app()->reporte->balanceAdmin($_GET['ids'],$topic,false);
            $files['balance']['excel']=Yii::app()->reporte->balanceAdmin($_GET['ids'],$topic,true);
            $files['balance']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['balance']['name'].".xls";    
        }
        if($_GET['table']=='balanceLibroVentas' || $_GET['table']=='balanceLibroVentasOculta')
        {
            $files['libroVentas']['name']=$_GET['name'];
            $files['libroVentas']['body']=Yii::app()->reporte->libroVenta($_GET['ids'],$topic,false);
            $files['libroVentas']['excel']=Yii::app()->reporte->libroVenta($_GET['ids'],$topic,true);
            $files['libroVentas']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['libroVentas']['name'].".xls";        
        }
        if($_GET['table']=='balanceReporteDepositos' || $_GET['table']=='balanceReporteDepositosOculta')
        {         
            $files['depositoBancario']['name']=$_GET['name'];
            $files['depositoBancario']['body']=Yii::app()->reporte->depositoBancario($_GET['ids'],$topic,false);
            $files['depositoBancario']['excel']=Yii::app()->reporte->depositoBancario($_GET['ids'],$topic,true);
            $files['depositoBancario']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['depositoBancario']['name'].".xls";    
        }
        if($_GET['table']=='balanceReporteBrighstar' || $_GET['table']=='balanceReporteBrighstarOculta')
        {
            $files['ventasbrighstar']['name']=$_GET['name'];
            $files['ventasbrighstar']['body']=Yii::app()->reporte->brightstar($_GET['ids'],$topic,false);
            $files['ventasbrighstar']['excel']=Yii::app()->reporte->brightstar($_GET['ids'],$topic,true);
            $files['ventasbrighstar']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['ventasbrighstar']['name'].".xls";    
        }
        if($_GET['table']=='balanceReporteCaptura' || $_GET['table']=='balanceReporteCapturaOculta')
        {
            $files['traficocaptura']['name']=$_GET['name'];
            $files['traficocaptura']['body']=Yii::app()->reporte->captura($_GET['ids'],$topic,false);
            $files['traficocaptura']['excel']=Yii::app()->reporte->captura($_GET['ids'],$topic,true);
            $files['traficocaptura']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['traficocaptura']['name'].".xls";    
        }
        if($_GET['table']=='balanceCicloIngresosResumido' || $_GET['table']=='balanceCicloIngresosResumidoOculta')
        {      
            $files['cicloIngreso']['name']=$_GET['name'];
            $files['cicloIngreso']['body']=Yii::app()->reporte->cicloIngreso($_GET['ids'],$topic,false,false);
            $files['cicloIngreso']['excel']=Yii::app()->reporte->cicloIngreso($_GET['ids'],$topic,false,true);
            $files['cicloIngreso']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['cicloIngreso']['name'].".xls";    
        }
        if($_GET['table']=='balanceCicloIngresosCompleto')
        {      
            $files['cicloIngresoC']['name']=$_GET['name'];
            $files['cicloIngresoC']['body']=Yii::app()->reporte->cicloIngreso($_GET['ids'],$topic,true,false);
            $files['cicloIngresoC']['excel']=Yii::app()->reporte->cicloIngreso($_GET['ids'],$topic,true,true);
            $files['cicloIngresoC']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['cicloIngresoC']['name'].".xls";    
        }
        if($_GET['table']=='balanceCicloIngresosTotalResumido' || $_GET['table']=='balanceCicloIngresosTotalResumidoOculta')
        {      
            $files['cicloIngresoT']['name']=$_GET['name'];
            $files['cicloIngresoT']['body']=Yii::app()->reporte->cicloIngresoTotal($_GET['ids'],$topic,false,false);
            $files['cicloIngresoT']['excel']=Yii::app()->reporte->cicloIngresoTotal($_GET['ids'],$topic,false,true);
            $files['cicloIngresoT']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['cicloIngresoT']['name'].".xls";    
        }
        if($_GET['table']=='tabla')
        {    
            $files['matriz']['name']=$_GET['name'];
            $files['matriz']['body']=Yii::app()->reporte->matrizGastos($_GET['mes'],$_GET['name'],$_GET['name'],false);
            $files['matriz']['excel']=Yii::app()->reporte->matrizGastos($_GET['mes'],$_GET['name'],$_GET['name'],true);
            $files['matriz']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['matriz']['name'].".xls";
        }
        if($_GET['table']=='tabla2')
        {
            $files['matrizE']['name']=$_GET['name'];
            $files['matrizE']['body']=Yii::app()->reporte->matrizGastosEvolucion($_GET['mes'],$_GET['cabina'],$_GET['name'],false);
            $files['matrizE']['excel']=Yii::app()->reporte->matrizGastosEvolucion($_GET['mes'],$_GET['cabina'],$_GET['name'],true);
            $files['matrizE']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['matrizE']['name'].".xls";
        }
        if($_GET['table']=='tabla3')
        {
            $files['TableroA']['name']=$_GET['name'];
            $files['TableroA']['body']=Yii::app()->reporte->tableroControl($_GET['date'],$_GET['name']);
            $files['TableroA']['excel']=Yii::app()->reporte->tableroControl($_GET['date'],$_GET['name']);
            $files['TableroA']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['TableroA']['name'].".xls";
        }
        if($_GET['table']=='estadogasto-grid')
        {
            $files['estadogasto']['name']=$_GET['name'];
            $files['estadogasto']['body']=Yii::app()->reporte->estadoGasto($_GET['ids'],$topic,false);
            $files['estadogasto']['excel']=Yii::app()->reporte->estadoGasto($_GET['ids'],$topic,true);
            $files['estadogasto']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['estadogasto']['name'].".xls";               
        }
        if($_GET['table']=='novedad-grid')
        {
            $files['novedadF']['name']=$_GET['name'];
            $files['novedadF']['body']=Yii::app()->reporte->novedadFalla($_GET['ids'],$_GET['name']);
            $files['novedadF']['excel']=Yii::app()->reporte->novedadFalla($_GET['ids'],$_GET['name']);
            $files['novedadF']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['novedadF']['name'].".xls";               
        }
        if($_GET['table']=='employee-grid')
        {
            $files['nominaE']['name']=$_GET['name'];
            $files['nominaE']['body']=Yii::app()->reporte->nominaEmpleado($_GET['ids'],$_GET['name']);
            $files['nominaE']['excel']=Yii::app()->reporte->nominaEmpleado($_GET['ids'],$_GET['name']);
            $files['nominaE']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['nominaE']['name'].".xls";               
        }
        if($_GET['table']=='log-grid')
        {
            $files['logs']['name']=$_GET['name'];
            $files['logs']['body']=Yii::app()->reporte->logs($_GET['ids'],$_GET['name']);
            $files['logs']['excel']=Yii::app()->reporte->logs($_GET['ids'],$_GET['name']);
            $files['logs']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['logs']['name'].".xls";               
        }
        if($_GET['table']=='reportePaBrightstar')
        {
            $files['PaBrightstar']['name']=$_GET['name'];
            $files['PaBrightstar']['body']=Yii::app()->reporte->pabrightstarReport($_GET['ids'],$_GET['name'],false);
            $files['PaBrightstar']['excel']=Yii::app()->reporte->pabrightstarReport($_GET['ids'],$_GET['name'],true);
            $files['PaBrightstar']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['PaBrightstar']['name'].".xls";               
        }
        if($_GET['table']=='tablaNomina')
        {
            $files['MatrizNo']['name']=$_GET['name'];
            $files['MatrizNo']['body']=Yii::app()->reporte->matrizNomina($_GET['mes'],$_GET['name'],false);
            $files['MatrizNo']['excel']=Yii::app()->reporte->matrizNomina($_GET['mes'],$_GET['name'],true);
            $files['MatrizNo']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['MatrizNo']['name'].".xls";               
        }
        if($_GET['table']=='cabina-grid')
        {
            $files['HorarioC']['name']=$_GET['name'];
            $files['HorarioC']['body']=Yii::app()->reporte->horarioCabina($_GET['ids'],$_GET['name']);
            $files['HorarioC']['excel']=Yii::app()->reporte->horarioCabina($_GET['ids'],$_GET['name']);
            $files['HorarioC']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['HorarioC']['name'].".xls";               
        }
        if($_GET['table']=='banco-grid')
        {
            $files['AbminBanco']['name']=$_GET['name'];
            $files['AbminBanco']['body']=Yii::app()->reporte->adminBanco($_GET['ids'],$_GET['name'],false);
            $files['AbminBanco']['excel']=Yii::app()->reporte->adminBanco($_GET['ids'],$_GET['name'],true);
            $files['AbminBanco']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['AbminBanco']['name'].".xls";               
        }
        if($_GET['table']=='DetailretesoMov')
        {
            $files['retesoMov']['name']=$_GET['name'];
            $files['retesoMov']['body']=Yii::app()->reporte->retesoMovimiento($_GET['ids'],$_GET['name'],false);
            $files['retesoMov']['excel']=Yii::app()->reporte->retesoMovimiento($_GET['ids'],$_GET['name'],true);
            $files['retesoMov']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['retesoMov']['name'].".xls";               
        }
        
        foreach($files as $key => $file)
        {   
            $this->genExcel($file['name'],utf8_encode($file['excel']),false);
            Yii::app()->correo->sendEmail($file['body'],$correo,$topic,$file['dir']);
        }
    }

    /**
     * @access public
     */
    public function actionPrint()
    { 
        if($_GET['table']=='balance-grid' || $_GET['table']=='balance-grid-oculta')
        {
            echo Yii::app()->reporte->balanceAdmin($_GET['ids'],$_GET['name'],false);
        }
        if($_GET['table']=='balanceLibroVentas' || $_GET['table']=='balanceLibroVentasOculta')
        {
            echo Yii::app()->reporte->libroVenta($_GET['ids'],$_GET['name'],false);
        }
        if($_GET['table']=='balanceReporteDepositos' || $_GET['table']=='balanceReporteDepositosOculta')
        {
            echo Yii::app()->reporte->depositoBancario($_GET['ids'],$_GET['name'],false);
        }
        if($_GET['table']=='balanceReporteBrighstar' || $_GET['table']=='balanceReporteBrighstarOculta')
        {
            echo Yii::app()->reporte->brightstar($_GET['ids'],$_GET['name'],false);
        }
        if($_GET['table']=='balanceReporteCaptura' || $_GET['table']=='balanceReporteCapturaOculta')
        {
            echo Yii::app()->reporte->captura($_GET['ids'],$_GET['name'],false);
        }
        if($_GET['table']=='balanceCicloIngresosResumido' || $_GET['table']=='balanceCicloIngresosResumidoOculta')
        {
            echo Yii::app()->reporte->cicloIngreso($_GET['ids'],$_GET['name'],false,false);
        }
        if($_GET['table']=='balanceCicloIngresosCompleto')
        {
            echo Yii::app()->reporte->cicloIngreso($_GET['ids'],$_GET['name'],true,false);
        }
        if($_GET['table']=='balanceCicloIngresosTotalResumido' || $_GET['table']=='balanceCicloIngresosTotalResumidoOculta')
        {
            echo Yii::app()->reporte->cicloIngresoTotal($_GET['ids'],$_GET['name'],false,false);
        }
        if($_GET['table']=='tabla'){
            echo Yii::app()->reporte->matrizGastos($_GET['mes'],$_GET['name'],false);
        }
        if($_GET['table']=='estadogasto-grid')
        {
            echo Yii::app()->reporte->estadoGasto($_GET['ids'],$_GET['name'],false);
        }
        if($_GET['table']=='tabla2')
        {
            echo Yii::app()->reporte->matrizGastosEvolucion($_GET['mes'],$_GET['cabina'],$_GET['name'],false);
        } 
        if($_GET['table']=='tabla3')
        {
            echo Yii::app()->reporte->tableroControl($_GET['date'],$_GET['name']);
        } 
        if($_GET['table']=='novedad-grid')
        {
            echo Yii::app()->reporte->novedadFalla($_GET['ids'],$_GET['name']);
        }
        if($_GET['table']=='employee-grid')
        {
            echo Yii::app()->reporte->nominaEmpleado($_GET['ids'],$_GET['name']);
        }
        if($_GET['table']=='log-grid')
        {
            echo Yii::app()->reporte->logs($_GET['ids'],$_GET['name']);
        }
        if($_GET['table']=='reportePaBrightstar')
        {
            echo Yii::app()->reporte->pabrightstarReport($_GET['ids'],$_GET['name'],false);
        }
        if($_GET['table']=='tablaNomina')
        {
            echo Yii::app()->reporte->matrizNomina($_GET['mes'],$_GET['name'],false);
        }
        if($_GET['table']=='cabina-grid')
        {
            echo Yii::app()->reporte->horarioCabina($_GET['ids'],$_GET['name']);
        }
        if($_GET['table']=='banco-grid')
        {
            echo Yii::app()->reporte->adminBanco($_GET['ids'],$_GET['name'],false);
        }
        if($_GET['table']=='DetailretesoMov')
        {
            echo Yii::app()->reporte->retesoMovimiento($_GET['ids'],$_GET['name'],false);
        }
    }
    
    /**
     * FUNCIONES PARA EXPORTAR A EXCEL, ENVIAR CORREO ELECTRONICO E IMPIRMIR
     * @access public
     */
    public function genExcel($name,$html,$salida=true)
    {
        if($salida)
        {
            header('Content-type: application/vnd.ms-excel');
            header("Content-Disposition: attachment; filename={$name}.xls");
            header("Pragma: cache");
            header("Expires: 0");
            echo $html;
        }
        else
        {
            $ruta=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR;
            $fp=fopen($ruta."$name.xls","w+");
            $cuerpo="<!DOCTYPE html>
                        <html>
                            <head>
                                <meta charset='utf-8'>
                                <meta http-equiv='Content-Type' content='application/vnd.ms-excel charset=utf-8'>
                            </head>
                            <body>";
            $cuerpo.=$html;
            $cuerpo.="</body>
            </html>";
            fwrite($fp,$cuerpo);
        }
    }
}