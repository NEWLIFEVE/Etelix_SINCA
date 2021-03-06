<!doctype html>
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

  <!-- blueprint CSS framework -->
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/screen.css" media="screen, projection" />
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" media="print" />
  <!--[if lt IE 8]>
  <link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->theme->baseUrl; ?>/css/ie.css" media="screen, projection" />
  <![endif]-->

  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form.css" />
  
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.js"></script>
  <script src="<?php echo Yii::app()->baseUrl; ?>/js/DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
  <script src="<?php echo Yii::app()->baseUrl; ?>/jPrintArea.js"></script>


  <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/scripts/jquery-ui.css" />
  <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/scripts/datePicker.css" />
<!--  <link rel="stylesheet" href="<?php //echo Yii::app()->baseUrl; ?>/scripts/jquery.ui.all.css" />-->
  <script src="<?php echo Yii::app()->baseUrl; ?>/scripts/jquery-1.9.1.js"></script>
  <script src="<?php echo Yii::app()->baseUrl; ?>/scripts/jquery-ui.js"></script>
 <script src="<?php echo Yii::app()->baseUrl; ?>/scripts/date.js"></script>
 <script src="<?php echo Yii::app()->baseUrl; ?>/scripts/jquery.datePicker.js"></script>
   
<!--  <link rel="stylesheet" href="/resources/demos/style.css" />-->


  <title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>

<!--<div class="container" id="wrapper">

  <header id="header">
    <div id="logo"><?php echo CHtml::link(CHtml::encode(Yii::app()->name), '/'); ?></div>

    <nav id="mainmenu">
      <?php
      /*Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/views.js");
      Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/themes/mattskitchen/css/estilos.css");
        Yii::import('webroot.protected.controllers.SiteController');
        Yii::import('webroot.protected.controllers.CabinaController');
        Yii::import('webroot.protected.modules.user.models.User');
        
          if(Yii::app()->user->isGuest){  
          $menuItems = array(
          array('label'=>'Home', 'url'=>array('/site/index')),
          array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>Yii::app()->getModule('user')->t("Login"), 'visible'=>Yii::app()->user->isGuest),
          array('url'=>Yii::app()->getModule('user')->registrationUrl, 'label'=>Yii::app()->getModule('user')->t("Register"), 'visible'=>Yii::app()->user->isGuest),
          //array('url'=>Yii::app()->getModule('user')->profileUrl, 'label'=>Yii::app()->getModule('user')->t("Profile"), 'visible'=>!Yii::app()->user->isGuest),
          //array('label'=>'Declarar', 'url'=>array('/balance/index'),'visible'=>!Yii::app()->user->isGuest),
          array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest),
                    );
         }



        if((!Yii::app()->user->isGuest)){
        
        //$resultSet = User::model()->find('username=:username',  array(':username'=>strtolower(Yii::app()->user->name)));
        //$tipoUsuario = Yii::app()->getModule('user')->user($resultSet->getAttribute('id'))->tipo;
        $tipoUsuario = Yii::app()->getModule('user')->user(Yii::app()->user->id)->tipo;
        $menuItems = SiteController::controlAcceso($tipoUsuario);        
        }
        
        /*
        $menuItems = array(
          array('label'=>'Home', 'url'=>array('/site/index')),
          array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>Yii::app()->getModule('user')->t("Login"), 'visible'=>Yii::app()->user->isGuest),
          array('url'=>Yii::app()->getModule('user')->registrationUrl, 'label'=>Yii::app()->getModule('user')->t("Register"), 'visible'=>Yii::app()->user->isGuest),
          array('url'=>Yii::app()->getModule('user')->profileUrl, 'label'=>Yii::app()->getModule('user')->t("Profile"), 'visible'=>!Yii::app()->user->isGuest),
          array('label'=>'Declarar', 'url'=>array('/balance/createApertura'),'visible'=>!Yii::app()->user->isGuest),
          array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest),
          //array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
          //array('label'=>'Contact', 'url'=>array('/site/contact')),
          //array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
          //array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
        );
         
  
        
         $this->widget('zii.widgets.CMenu',array(
        'items'=>$menuItems,
        'firstItemCssClass'=>'first',
        'lastItemCssClass'=>'last',
      )); */?>
    </nav>--><!-- mainmenu -->
    
 <!-- </header>--><!-- header -->
<div class="info" style='text-align:left;'>
  <?php 
  $flashMessages = Yii::app()->user->getFlashes();
  if($flashMessages){
      echo '<ul class="flashes" >';
      foreach ($flashMessages as $key=> $message){
          echo '<div class="flash-' .$key. '">' . $message ."</div>\n";
      }
      echo '</ul>';
  }
  ?>
  </div>
  <div class="nota" style='text-align:right;color: #E6ECFF;'>
      <?php
        if (!Yii::app()->user->isGuest && Yii::app()->getModule('user')->user(Yii::app()->user->id)->tipo==1)
            echo 'NOTA: Recuerde Cerrar la Sesion al terminar su JORNADA LABORAL';   
      ?></div>
  <div id="main-wrapper"><div id="main" role="main">

    <?php echo $content; ?>
  </div></div><!-- main -->
  
  <footer id="footer">
    <nav id="footermenu">
      <?php $this->widget('zii.widgets.CMenu',array('items'=>$menuItems)); ?>
    </nav>
    <div class="content">
      <?php echo 'Copyright 2013 by <a href="http://www.sacet.com.ve/" rel="external"> www.sacet.com.ve</a> Legal privacy' // echo Yii::powered(); ?>
    </div>
  </footer><!-- footer -->

</div><!-- wrapper -->

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
    'speed' => 'slow'
    ));
?>
