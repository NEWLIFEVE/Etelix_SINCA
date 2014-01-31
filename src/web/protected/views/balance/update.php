<?php
/* @var $this BalanceController */
/* @var $model Balance */

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=BalanceController::controlAcceso($tipoUsuario);
?>

<h1>Actualizar Balance <?php echo $model->Id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>