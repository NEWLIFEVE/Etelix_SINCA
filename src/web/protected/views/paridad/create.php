<?php
/* @var $this ParidadController */
/* @var $model Paridad */


$this->breadcrumbs=array(
	'Paridads'=>array('index'),
	'Create',
);

Yii::import('webroot.protected.controllers.BancoController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= BancoController::controlAcceso($tipoUsuario);
//$this->menu=array(
//	array('label'=>'List Paridad', 'url'=>array('index')),
//	array('label'=>'Manage Paridad', 'url'=>array('admin')),
//);
?>

<h1>Actualizar Paridad Cambiaria</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>