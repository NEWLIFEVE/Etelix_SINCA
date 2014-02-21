<?php

Yii::import('webroot.protected.modules.user.models.User');

class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error = Yii::app()->errorHandler->error)
        {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     *
     */
    public function actionSessionFinished()
    {
        $this->render('sessionFinished', '');
    }

    /**
     * Displays the contact page
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
                $headers="From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model=new LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes = $_POST['LoginForm'];

            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     *
     */
    public static function actionMail()
    {
        $mailer=new EnviarEmail;
    }
   
    /**
     * Esta funcion se encarga de devolver el arreglo con el Menu del sistema dependiendo del tipo de usuario 
     */
    public static function controlAcceso($tipoUsuario)
    {
        $idUsuario=Yii::app()->user->id;
        /* OPERADOR DE CABINA */
        if($tipoUsuario==1)
        {
            return array(
                //array('label' => 'Home', 'url' => array('/site/index')),
                array('url' => Yii::app()->getModule('user')->loginUrl, 'label' => Yii::app()->getModule('user')->t("Login"), 'visible' => Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->registrationUrl, 'label' => Yii::app()->getModule('user')->t("Register"), 'visible' => Yii::app()->user->isGuest),
                array('url' => array('/log/createInicioJornada'), 'label' => 'Declarar', 'visible' => !Yii::app()->user->isGuest),
                array('url' => array('/novedad/create'), 'label' => 'Novedades/Fallas', 'visible' => !Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->logoutUrl, 'label' => Yii::app()->getModule('user')->t("Logout") . ' (' . Yii::app()->getModule('user')->user($idUsuario)->username . '/' . Cabina::getNombreCabina(Yii::app()->getModule('user')->user($idUsuario)->CABINA_Id) . ')', 'visible' => !Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->profileUrl, 'label' => Yii::app()->getModule('user')->t("Profile"), 'visible' => !Yii::app()->user->isGuest),
            );
        }
        /* GERENTE DE OPERACIONES */
        if ($tipoUsuario == 2) {
            return array(
                //array('label' => 'Home', 'url' => array('/site/index')),
                array('url' => Yii::app()->getModule('user')->loginUrl, 'label' => Yii::app()->getModule('user')->t("Login"), 'visible' => Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->registrationUrl, 'label' => Yii::app()->getModule('user')->t("Register"), 'visible' => Yii::app()->user->isGuest),
                //array('url' => array('/recargas/index'), 'label' => 'Transferencias', 'visible' => !Yii::app()->user->isGuest),
                array('url' => array('/balance/index'), 'label' => 'Reportes/Balances', 'visible' => !Yii::app()->user->isGuest),
                array('url'=>array('/pabrightstar/create'),'label'=>'P.A.B.', 'visible'=>!Yii::app()->user->isGuest),        
                array('url'=>array('/detallegasto/create'),'label'=>'Gastos', 'visible'=>!Yii::app()->user->isGuest),        
                array('url' => Yii::app()->getModule('user')->logoutUrl, 'label' => Yii::app()->getModule('user')->t("Logout") . ' (' . Yii::app()->getModule('user')->user($idUsuario)->username . '/GerenteOp)', 'visible' => !Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->profileUrl, 'label' => Yii::app()->getModule('user')->t("Profile"), 'visible' => !Yii::app()->user->isGuest),
            );
        }
        /* ADMINISTRADOR */
        if ($tipoUsuario == 3) {
            return array(
                //array('label' => 'Home', 'url' => array('/site/index')),
                array('url' => Yii::app()->getModule('user')->loginUrl, 'label' => Yii::app()->getModule('user')->t("Login"), 'visible' => Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->registrationUrl, 'label' => Yii::app()->getModule('user')->t("Register"), 'visible' => Yii::app()->user->isGuest),
                array('url' => array('/balance/controlPanel'), 'label' => 'Balances', 'visible' => !Yii::app()->user->isGuest),
                array('url'=>array('/pabrightstar/admin'),'label'=>'P.A.B.', 'visible'=>!Yii::app()->user->isGuest), 
                array('url'=>array('/detallegasto/estadoGastos'),'label'=>'Gastos', 'visible'=>!Yii::app()->user->isGuest), 
                array('url' => array('/novedad/admin'), 'label' => 'Novedades/Fallas', 'visible' => !Yii::app()->user->isGuest),
                array('url' => array('/nomina/adminEmpleado'), 'label' => 'Nomina', 'visible' => !Yii::app()->user->isGuest),
                array('url' => array('/log/admin'), 'label' => 'Log', 'visible' => !Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->logoutUrl, 'label' => Yii::app()->getModule('user')->t("Logout") . ' (' . Yii::app()->getModule('user')->user($idUsuario)->username . '/Admin)', 'visible' => !Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->profileUrl, 'label' => Yii::app()->getModule('user')->t("Profile"), 'visible' => !Yii::app()->user->isGuest),
            );
        }
        /* TESORERO */
        if ($tipoUsuario == 4) {
            return array(
                //array('label' => 'Home', 'url' => array('/site/index')),
                array('url' => Yii::app()->getModule('user')->loginUrl, 'label' => Yii::app()->getModule('user')->t("Login"), 'visible' => Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->registrationUrl, 'label' => Yii::app()->getModule('user')->t("Register"), 'visible' => Yii::app()->user->isGuest),
                array('url' => array('/balance/reporteDepositos'), 'label' => 'Reportes', 'visible' => !Yii::app()->user->isGuest),
                array('url' => array('/paridad/create'), 'label' => 'Banco/Tesoreria', 'visible' => !Yii::app()->user->isGuest),
                //array('url'=>array('/brightstar/index'),'label'=>'P.A.Brightstar', 'visible'=>!Yii::app()->user->isGuest),        
                array('url' => Yii::app()->getModule('user')->logoutUrl, 'label' => Yii::app()->getModule('user')->t("Logout") . ' (' . Yii::app()->getModule('user')->user($idUsuario)->username . '/Tesorero)', 'visible' => !Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->profileUrl, 'label' => Yii::app()->getModule('user')->t("Profile"), 'visible' => !Yii::app()->user->isGuest),
            );
        }
        /* SOCIO */
        if ($tipoUsuario == 5) {
            return array(
                //array('label' => 'Home', 'url' => array('/site/index')),
                array('url' => Yii::app()->getModule('user')->loginUrl, 'label' => Yii::app()->getModule('user')->t("Login"), 'visible' => Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->registrationUrl, 'label' => Yii::app()->getModule('user')->t("Register"), 'visible' => Yii::app()->user->isGuest),
                array('url' => array('/balance/controlPanel'), 'label' => 'Reportes', 'visible' => !Yii::app()->user->isGuest),
                array('url'=>array('/pabrightstar/admin'),'label'=>'P.A.B.', 'visible'=>!Yii::app()->user->isGuest), 
                array('url' => array('/novedad/admin'), 'label' => 'Novedades/Fallas', 'visible' => !Yii::app()->user->isGuest),
                array('url' => array('/log/admin'), 'label' => 'Log', 'visible' => !Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->logoutUrl, 'label' => Yii::app()->getModule('user')->t("Logout") . ' (' . Yii::app()->getModule('user')->user($idUsuario)->username . '/Socio)', 'visible' => !Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->profileUrl, 'label' => Yii::app()->getModule('user')->t("Profile"), 'visible' => !Yii::app()->user->isGuest),
            );
        }
        /* GERENTE DE CONTABILIDAD */
        if ($tipoUsuario == 6) {
            return array(
                //array('label' => 'Home', 'url' => array('/site/index')),
                array('url' => Yii::app()->getModule('user')->loginUrl, 'label' => Yii::app()->getModule('user')->t("Login"), 'visible' => Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->registrationUrl, 'label' => Yii::app()->getModule('user')->t("Register"), 'visible' => Yii::app()->user->isGuest),
                array('url' => array('/balance/controlPanel'), 'label' => 'Reportes', 'visible' => !Yii::app()->user->isGuest),
                array('url'=>array('/detallegasto/estadoGastos'),'label'=>'Gastos', 'visible'=>!Yii::app()->user->isGuest), 
                array('url'=>array('/pabrightstar/admin'),'label'=>'P.A.B.', 'visible'=>!Yii::app()->user->isGuest), 
                array('url' => Yii::app()->getModule('user')->logoutUrl, 'label' => Yii::app()->getModule('user')->t("Logout") . ' (' . Yii::app()->getModule('user')->user($idUsuario)->username . '/GerenteCont)', 'visible' => !Yii::app()->user->isGuest),
                array('url' => Yii::app()->getModule('user')->profileUrl, 'label' => Yii::app()->getModule('user')->t("Profile"), 'visible' => !Yii::app()->user->isGuest),
            );
        }
    }

    /**
     *
     */
    public static function mensajesConfirm($tipo)
    {
        switch ($tipo) {
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
     */
    public function actionExcel()
    {  

        $files=array();
        
        if($_GET['table']=='balance-grid' || $_GET['table']=='balance-grid-oculta'){
            
               $files['balance']['name']='Administrar_Balance_de_Cabinas';
               $files['balance']['body']=Yii::app()->reporte->balanceAdmin($_GET['ids']);   
        }
        if($_GET['table']=='balanceLibroVentas' || $_GET['table']=='balanceLibroVentasOculta'){
            
               $files['libroVentas']['name']='Reporte_Libro_de_Ventas';
               $files['libroVentas']['body']=Yii::app()->reporte->libroVenta($_GET['ids']);
        }
        if($_GET['table']=='balanceReporteDepositos' || $_GET['table']=='balanceReporteDepositosOculta'){
            
               $files['depositoBancario']['name']='Reporte_de_Depositos_Bancarios';
               $files['depositoBancario']['body']=Yii::app()->reporte->depositoBancario($_GET['ids']);
        }
        if($_GET['table']=='balanceReporteBrighstar' || $_GET['table']=='balanceReporteBrighstarOculta'){
                 
               $files['ventasbrighstar']['name']='Reporte_de_Ventas_Recargas_Brighstar';
               $files['ventasbrighstar']['body']=Yii::app()->reporte->brightstar($_GET['ids']);
        }
        if($_GET['table']=='balanceReporteCaptura' || $_GET['table']=='balanceReporteCapturaOculta'){
                 
               $files['traficocaptura']['name']='Reporte_de_Trafico_Captura';
               $files['traficocaptura']['body']=Yii::app()->reporte->captura($_GET['ids']);
        }
        if($_GET['table']=='balanceCicloIngresosResumido' || $_GET['table']=='balanceCicloIngresosResumidoOculta'){
              
               $files['cicloIngreso']['name']='Ciclo_de_Ingresos_Resumido';
               $files['cicloIngreso']['body']=Yii::app()->reporte->cicloIngreso($_GET['ids'],false);   
        }
        if($_GET['table']=='balanceCicloIngresosCompletoActivas' || $_GET['table']=='balanceCicloIngresosCompletoInactivas'){
              
               $files['cicloIngresoC']['name']='Ciclo_de_Ingresos_Completo';
               $files['cicloIngresoC']['body']=Yii::app()->reporte->cicloIngreso($_GET['ids'],true);  
        }
       if($_GET['table']=='balanceCicloIngresosTotalResumido' || $_GET['table']=='balanceCicloIngresosTotalResumidoOculta'){
              
               $files['cicloIngresoT']['name']='Ciclo_de_Ingresos_Total';
               $files['cicloIngresoT']['body']=Yii::app()->reporte->cicloIngresoTotal($_GET['ids'],false);
        }
        if($_GET['table']=='tabla'){
            $files['matriz']['name']='Matriz de Gastos';
            $files['matriz']['body']=Yii::app()->reporte->matrizGastos(Yii::app()->user->getState('mesSesion'));
        }
        if($_GET['table']=='estadogasto-grid'){
            $files['estadogasto']['name']=$_GET['name'];
            $files['estadogasto']['body']=Yii::app()->reporte->estadoGasto($_GET['ids']);
        }
        
        foreach($files as $key => $file)
        {
            $this->genExcel($file['name'],$file['body'],true);
        }
    }
    
    /**
     *
     */
    public function actionSendEmail()
    {

        $correo = Yii::app()->getModule('user')->user()->email;

        $topic = $_GET['name'];
        
        $files=array();
        
        if($_GET['table']=='balance-grid' || $_GET['table']=='balance-grid-oculta'){
            
               $files['balance']['name']=$_GET['name'];
               $files['balance']['body']=Yii::app()->reporte->balanceAdmin($_GET['ids']);
               $files['balance']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['balance']['name'].".xls";
                
        }
        if($_GET['table']=='balanceLibroVentas' || $_GET['table']=='balanceLibroVentasOculta'){
                 
               $files['libroVentas']['name']=$_GET['name'];
               $files['libroVentas']['body']=Yii::app()->reporte->libroVenta($_GET['ids']);
               $files['libroVentas']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['libroVentas']['name'].".xls";
                
        }
        if($_GET['table']=='balanceReporteDepositos' || $_GET['table']=='balanceReporteDepositosOculta'){
                 
               $files['depositoBancario']['name']=$_GET['name'];
               $files['depositoBancario']['body']=Yii::app()->reporte->depositoBancario($_GET['ids']);
               $files['depositoBancario']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['depositoBancario']['name'].".xls";
                
        }
        if($_GET['table']=='balanceReporteBrighstar' || $_GET['table']=='balanceReporteBrighstarOculta'){
                 
               $files['ventasbrighstar']['name']=$_GET['name'];
               $files['ventasbrighstar']['body']=Yii::app()->reporte->brightstar($_GET['ids']);
               $files['ventasbrighstar']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['ventasbrighstar']['name'].".xls";
                
        }
        if($_GET['table']=='balanceReporteCaptura' || $_GET['table']=='balanceReporteCapturaOculta'){
                 
               $files['traficocaptura']['name']=$_GET['name'];
               $files['traficocaptura']['body']=Yii::app()->reporte->captura($_GET['ids']);
               $files['traficocaptura']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['traficocaptura']['name'].".xls";
                
        }
        if($_GET['table']=='balanceCicloIngresosResumido' || $_GET['table']=='balanceCicloIngresosResumidoOculta'){
              
               $files['cicloIngreso']['name']=$_GET['name'];
               $files['cicloIngreso']['body']=Yii::app()->reporte->cicloIngreso($_GET['ids'],false);
               $files['cicloIngreso']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['cicloIngreso']['name'].".xls";
                
        }
        if($_GET['table']=='balanceCicloIngresosCompletoActivas' || $_GET['table']=='balanceCicloIngresosCompletoInactivas'){
              
               $files['cicloIngreso']['name']=$_GET['name'];
               $files['cicloIngreso']['body']=Yii::app()->reporte->cicloIngreso($_GET['ids'],true);
               $files['cicloIngreso']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['cicloIngreso']['name'].".xls";
                
        }
        if($_GET['table']=='balanceCicloIngresosTotalResumido' || $_GET['table']=='balanceCicloIngresosTotalResumidoOculta'){
              
               $files['cicloIngresoT']['name']=$_GET['name'];
               $files['cicloIngresoT']['body']=Yii::app()->reporte->cicloIngresoTotal($_GET['ids'],false);
               $files['cicloIngresoT']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['cicloIngresoT']['name'].".xls";
                
        }
        if($_GET['table']=='tabla'){
            
            $files['matriz']['name']=$_GET['name'];
            $files['matriz']['body']=Yii::app()->reporte->matrizGastos(Yii::app()->user->getState('mesSesion'));
            $files['matriz']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['matriz']['name'].".xls";
        
               
        }
        if($_GET['table']=='estadogasto-grid'){
            
            $files['estadogasto']['name']=$_GET['name'];
            $files['estadogasto']['body']=Yii::app()->reporte->estadoGasto($_GET['ids']);
            $files['estadogasto']['dir']=Yii::getPathOfAlias('webroot.adjuntos').DIRECTORY_SEPARATOR.$files['estadogasto']['name'].".xls";
        
               
        }
        
        foreach($files as $key => $file)
        {   
            
            $this->genExcel($file['name'],utf8_encode($file['body']),false);
            Yii::app()->correo->sendEmail($file['body'],$correo,$topic,$file['dir']);
        }

    }

    /**
     *
     */
    public function actionPrint()
    { 
        if($_GET['table']=='balance-grid' || $_GET['table']=='balance-grid-oculta')
        {
            echo Yii::app()->reporte->balanceAdmin($_GET['ids']);
        }
        if($_GET['table']=='balanceLibroVentas' || $_GET['table']=='balanceLibroVentasOculta')
        {
            echo Yii::app()->reporte->libroVenta($_GET['ids']);
        }
        if($_GET['table']=='balanceReporteDepositos' || $_GET['table']=='balanceReporteDepositosOculta')
        {
            echo Yii::app()->reporte->depositoBancario($_GET['ids']);
        }
        if($_GET['table']=='balanceReporteBrighstar' || $_GET['table']=='balanceReporteBrighstarOculta')
        {
            echo Yii::app()->reporte->brightstar($_GET['ids']);
        }
        if($_GET['table']=='balanceReporteCaptura' || $_GET['table']=='balanceReporteCapturaOculta')
        {
            echo Yii::app()->reporte->captura($_GET['ids']);
        }
        if($_GET['table']=='balanceCicloIngresosResumido' || $_GET['table']=='balanceCicloIngresosResumidoOculta')
        {
            echo Yii::app()->reporte->cicloIngreso($_GET['ids'],false);
        }
        if($_GET['table']=='balanceCicloIngresosCompletoActivas' || $_GET['table']=='balanceCicloIngresosCompletoInactivas')
        {
            echo Yii::app()->reporte->cicloIngreso($_GET['ids'],true);
        }
        if($_GET['table']=='balanceCicloIngresosTotalResumido' || $_GET['table']=='balanceCicloIngresosTotalResumidoOculta')
        {
            echo Yii::app()->reporte->cicloIngresoTotal($_GET['ids'],false);
        }
        if($_GET['table']=='tabla'){
            echo Yii::app()->reporte->matrizGastos(Yii::app()->user->getState('mesSesion'));
        }
        if($_GET['table']=='estadogasto-grid'){
            echo Yii::app()->reporte->estadoGasto($_GET['ids']);
        }
               
        
    }
    
    /**
     * FUNCIONES PARA EXPORTAR A EXCEL, ENVIAR CORREO ELECTRONICO E IMPIRMIR
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
            $cuerpo="
            <!DOCTYPE html>
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