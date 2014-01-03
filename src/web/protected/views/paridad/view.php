<?php
/* @var $this ParidadController */
/* @var $model Paridad */

$this->breadcrumbs=array(
	'Paridads'=>array('index'),
	$model->Id,
);

$this->menu=array(
	array('label'=>'List Paridad', 'url'=>array('index')),
	array('label'=>'Create Paridad', 'url'=>array('create')),
	array('label'=>'Update Paridad', 'url'=>array('update', 'id'=>$model->Id)),
	array('label'=>'Delete Paridad', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Paridad', 'url'=>array('admin')),
);
?>

<h1>View Paridad #<?php echo $model->Id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id',
		'Fecha',
		'Valor',
	),
)); ?>
