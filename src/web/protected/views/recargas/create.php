<?php
/* @var $this RecargasController */
/* @var $model Recargas */

$this->breadcrumbs=array(
	'Recargases'=>array('index'),
	'Create',
);
Yii::import('webroot.protected.controllers.PabrightstarController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= PabrightstarController::controlAcceso($tipoUsuario);
//$this->menu=array(
//	array('label'=>'List Recargas', 'url'=>array('index')),
//	array('label'=>'Manage Recargas', 'url'=>array('admin')),
//);
?>

<h1>Hacer Recargas P.D.V.</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>