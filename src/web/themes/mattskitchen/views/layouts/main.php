<!DOCTYPE html>
<!--[if lt IE 6]> <html class="no-js ie6 oldie" lang="en"> <![endif]
[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]
[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]
[if gt IE 8]> <html class="no-js" lang="en"> <![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <meta name="language" content="en" />
        <link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" media="print" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datepicker.css" />
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css'); ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
        <script>window.jQuery || document.write(unescape('%3Cscript src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-ui-1.10.3/jquery-1.9.1.js"%3E%3C/script%3E'))</script>
        <script>window.jQuery || document.write(unescape('%3Cscript src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-ui-1.10.3/ui/jquery-ui.js"%3E%3C/script%3E'))</script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/sinca.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/views.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/estadoGastos.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.10.1.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.fancybox.js?v=2.1.5"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.fancybox.css?v=2.1.5" media="screen" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        <div class="container" id="wrapper">
            <header id="header">
                <div id="logo"><?php echo CHtml::link(CHtml::encode(Yii::app()->name), '/'); ?></div>
                <nav id="mainmenu">
                    <?php
                    Yii::import('webroot.protected.controllers.SiteController');
                    Yii::import('webroot.protected.controllers.CabinaController');
                    Yii::import('webroot.protected.modules.user.models.User');
                    if(Yii::app()->user->isGuest)
                    {
                        $menuItems=array(
                            array(
                                'url'=>Yii::app()->getModule('user')->logoutUrl,
                                'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->user->name.')', 
                                'visible'=>!Yii::app()->user->isGuest
                                ),
                            );
                    }
                    if((!Yii::app()->user->isGuest))
                    {
                        $tipoUsuario=Yii::app()->getModule('user')->user(Yii::app()->user->id)->tipo;
                        $menuItems=SiteController::controlAcceso($tipoUsuario);
                    }
                    $this->widget('zii.widgets.CMenu',array(
                        'items'=>$menuItems,
                        'firstItemCssClass'=>'first',
                        'lastItemCssClass'=>'last',
                        )
                        );
                    ?>
                </nav>
                <!-- mainmenu -->
            </header>
            <!-- header -->
            <div class="info" style='text-align:left;'>
                <?php
                $flashMessages=Yii::app()->user->getFlashes();
                if($flashMessages)
                {
                    echo '<ul class="flashes">';
                    foreach ($flashMessages as $key=> $message)
                    {
                        echo '<div class="flash-'.$key.'">'.$message."</div>\n";
                    }
                    echo '</ul>';
                }
                ?>
            </div>
            <div class="nota">
                <?php
                if(!Yii::app()->user->isGuest && Yii::app()->getModule('user')->user(Yii::app()->user->id)->tipo==1) echo 'NOTA: Recuerde Cerrar la Sesion al terminar su JORNADA LABORAL';
                ?>
            </div>
            <div id="main-wrapper">
                <div id="main" role="main">
                    <?php echo $content; ?>
                </div>
            </div>
            <!-- main -->
            <footer id="footer">
                <nav id="footermenu">
                    <h5 style="color:#FFF ">S I N C A - v1.8.1</h5>
                </nav>
                <div class="content">
                    <?php echo 'Copyright 2014 by <a href="http://www.sacet.com.ve/" rel="external"> www.sacet.com.ve</a> Legal privacy' ?>
                </div>
            </footer>
            <!-- footer -->
        </div>
        <!-- wrapper -->
    </body>
</html>
<?php
// Efecto para el div de Mensajes Flash
Yii::app()->clientScript->registerScript(
    'myHideEffect',
    '$(".info").animate({opacity: 1.0}, 5000).slideUp("slow");',
    CClientScript::POS_READY
    );
$this->widget('ext.scrolltop.ScrollTop', array(
//Default values
    'fadeTransitionStart'=>10,
    'fadeTransitionEnd'=>200,
    'speed'=>'slow'
    )
);
?>