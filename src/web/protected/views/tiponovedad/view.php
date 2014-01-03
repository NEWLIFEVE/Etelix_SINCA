<?php
/* @var $this TiponovedadController */
/* @var $model Tiponovedad */

$this->breadcrumbs=array(
	'Tiponovedads'=>array('index'),
	$model->Id,
);

$this->menu=array(
	array('label'=>'List Tiponovedad', 'url'=>array('index')),
	array('label'=>'Create Tiponovedad', 'url'=>array('create')),
	array('label'=>'Update Tiponovedad', 'url'=>array('update', 'id'=>$model->Id)),
	array('label'=>'Delete Tiponovedad', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Tiponovedad', 'url'=>array('admin')),
);
?>

<h1>View Tiponovedad #<?php echo $model->Id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id',
		'Nombre',
	),
)); ?>
