<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Sesión finalizada';
$this->breadcrumbs=array(
	'Error',
);
?>

<h2>La sesi&oacute;n ha expirado</h2>

<div class="error">
<?php
    if(!Yii::app()->user->isGuest){
            Yii::app()->request->redirect(Yii::app()->createUrl('site/index'));
    }
    elseif(Yii::app()->user->isGuest){
        $mensaje = "<h5>Por razones de seguridad su sesi&oacute;n en el sistema fue cerrada. Por favor haga clic <a href=".Yii::app()->createAbsoluteUrl('user/login')." >aqu&iacute;</a> e ingrese nuevamente su usuario y su contrase&ntilde;a en el sistema.</h5>";
        echo $mensaje;
    }
?>
</div>