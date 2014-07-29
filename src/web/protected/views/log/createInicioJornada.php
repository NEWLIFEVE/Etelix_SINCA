<?php
/* @var $this LogController */
/* @var $model Log */

$this->breadcrumbs=array(
	'Logs'=>array('index'),
	'Create',
);
Yii::import('webroot.protected.controllers.BalanceController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  DetalleingresoController::controlAcceso($tipoUsuario);
//$this->menu=array(
//	array('label'=>'List Log', 'url'=>array('index')),
//	array('label'=>'Manage Log', 'url'=>array('admin')),
//);
?>

<h1>Declarar Inicio de Jornada Laboral</h1>

<?php 
if($existe)
{
	echo "Usted ya declaró inicio de jornada";
}
else
{
	echo $this->renderPartial('_form_iniciojornada', array('model'=>$model));
}
?>