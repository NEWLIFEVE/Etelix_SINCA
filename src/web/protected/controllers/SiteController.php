<?php

Yii::import('webroot.protected.modules.user.models.User');

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
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
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionSessionFinished() {

        $this->render('sessionFinished', '');

    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
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
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
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
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public static function actionMail(){
        $mailer = new EnviarEmail;
    }
   
    /* Esta funcion se encarga de devolver el arreglo con el Menu del sistema dependiendo del tipo de usuario */

    public static function controlAcceso($tipoUsuario) {
        $idUsuario = Yii::app()->user->id;
        /* OPERADOR DE CABINA */
        if ($tipoUsuario == 1) {
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

    public static function mensajesConfirm($tipo) {
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
    
    public function actionExcel()
    {  

        $archivos=array();
        
        $archivos['balance']['nombre']=$_GET['name'];
        $archivos['balance']['cuerpo']=Yii::app()->reporte->balanceAdmin($_GET['ids']);
        
        
        foreach($archivos as $key => $archivo)
        {
            $this->genExcel($archivo['nombre'],$archivo['cuerpo']);
        }

    }

    public function genExcel($nombre,$html)
    {   
        header("Content-type: application/vnd.ms-excel; charset=utf-8"); 
        header("Content-Disposition: attachment; filename={$nombre}.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $html;
        

    }
 
}