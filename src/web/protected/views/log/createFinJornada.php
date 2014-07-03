<?php
/* @var $this LogController */
/* @var $model Log */

$this->breadcrumbs=array(
	'Logs'=>array('index'),
	'Create',
);
Yii::import('webroot.protected.controllers.BalanceController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=DetalleingresoController::controlAcceso($tipoUsuario);
//$this->menu=array(
//	array('label'=>'List Log', 'url'=>array('index')),
//	array('label'=>'Manage Log', 'url'=>array('admin')),
//);
?>

<h1>Declarar Fin de Jornada Laboral</h1>

<?php echo $this->renderPartial('_form_finjornada', array('model'=>$model)); ?>