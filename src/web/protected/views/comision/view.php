<?php
/* @var $this ComisionController */
/* @var $model Comision */

$this->breadcrumbs=array(
	'Comisions'=>array('index'),
	$model->Id,
);
Yii::import('webroot.protected.controllers.PabrightstarController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= PabrightstarController::controlAcceso($tipoUsuario);
//$this->menu=array(
//	array('label'=>'List Comision', 'url'=>array('index')),
//	array('label'=>'Create Comision', 'url'=>array('create')),
//	array('label'=>'Update Comision', 'url'=>array('update', 'id'=>$model->Id)),
//	array('label'=>'Delete Comision', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Comision', 'url'=>array('admin')),
//);
?>

<h1>Comision #<?php echo $model->Id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id',
		'Fecha',
		'Valor',
		'COMPANIA_Id',
	),
)); ?>
