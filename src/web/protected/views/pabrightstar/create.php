<?php
/* @var $this PabrightstarController */
/* @var $model Pabrightstar */

$this->breadcrumbs=array(
	'Pabrightstars'=>array('index'),
	'Create',
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= PabrightstarController::controlAcceso($tipoUsuario);
//$this->menu=array(
//	array('label'=>'List Pabrightstar', 'url'=>array('index')),
//	array('label'=>'Manage Pabrightstar', 'url'=>array('admin')),
//);
?>

<h1>Declarar Transferencia al P.A. Brightstar</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>