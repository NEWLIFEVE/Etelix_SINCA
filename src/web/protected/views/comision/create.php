<?php
/* @var $this ComisionController */
/* @var $model Comision */

$this->breadcrumbs=array(
	'Comisions'=>array('index'),
	'Create',
);
Yii::import('webroot.protected.controllers.PabrightstarController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= PabrightstarController::controlAcceso($tipoUsuario);
//$this->menu=array(
//	array('label'=>'List Comision', 'url'=>array('index')),
//	array('label'=>'Manage Comision', 'url'=>array('admin')),
//);
?>

<h1>Actualizar Comision P.A.</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>