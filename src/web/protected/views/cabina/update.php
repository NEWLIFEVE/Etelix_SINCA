<?php
/* @var $this CabinaController */
/* @var $model Cabina */

Yii::import('webroot.protected.controllers.BalanceController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=DetalleingresoController::controlAcceso($tipoUsuario);
?>

<!--<h1>Update Cabina <?php // echo $model->Id; ?></h1>-->
<h1>
  <span class="enviar" style="position: relative; top: -7px;">
    <?php echo 'Actualizar Horario - '.$model->Nombre; ?> 
  </span >
</h1>

<?php echo $this->renderPartial('_formHours', array('model'=>$model,'model_hours'=>$model_hours)); ?>