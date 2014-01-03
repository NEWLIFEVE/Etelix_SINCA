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
  <!-- blueprint CSS framework -->
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/screen.css" media="screen, projection" />
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" media="print" />
  <!--[if lt IE 8]>
  <link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->theme->baseUrl; ?>/css/ie.css" media="screen, projection" />
  <![endif]-->
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form.css" /> 
  <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/js/jquery-ui-1.10.3/themes/base/jquery-ui.css" />
  <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/js/jquery-ui-1.10.3/themes/base/jquery.ui.datepicker.css" />
  <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/js/jquery-ui-1.10.3/themes/base/jquery.ui.all.css" />
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
                'visible'=>!Yii::app()->user->isGuest),
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
          echo '<ul class="flashes" >';
          foreach($flashMessages as $key => $message)
          {
            echo '<div class="flash-'.$key.'">'.$message."</div>\n";
          }
          echo '</ul>';
        }
      ?>
    </div>
    <div class="nota" style='text-align:right;color: #E6ECFF;'>
      <?php
        if(!Yii::app()->user->isGuest&&Yii::app()->getModule('user')->user(Yii::app()->user->id)->tipo==1)
          echo 'NOTA: Recuerde Cerrar la Sesion al terminar su JORNADA LABORAL';
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
        <?php $this->widget('zii.widgets.CMenu',array('items'=>$menuItems)); ?>
      </nav>
      <div class="content">
        <?php echo 'Copyright 2013 by <a href="http://www.sacet.com.ve/" rel="external"> www.sacet.com.ve</a> Legal privacy'; ?>
      </div>
    </footer>
    <!-- footer -->
  </div>
  <!-- wrapper -->
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.10.3/ui/jquery.ui.datepicker.js"></script>
  <script>window.jQuery || document.write(unescape('%3Cscript src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-ui-1.10.3/jquery-1.9.1.js"%3E%3C/script%3E'))</script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script>window.jQuery || document.write(unescape('%3Cscript src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-ui-1.10.3/ui/jquery-ui.js"%3E%3C/script%3E'))</script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.js"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/views.js"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/sinca.js"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/estadoGastos.js"></script>
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