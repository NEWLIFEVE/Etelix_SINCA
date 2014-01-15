<?php
/* @var $this AccionlogController */
/* @var $model Accionlog */

$this->breadcrumbs=array(
	'Accionlogs'=>array('index'),
	$model->Id,
);

$this->menu=array(
	array('label'=>'List Accionlog', 'url'=>array('index')),
	array('label'=>'Create Accionlog', 'url'=>array('create')),
	array('label'=>'Update Accionlog', 'url'=>array('update', 'id'=>$model->Id)),
	array('label'=>'Delete Accionlog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Accionlog', 'url'=>array('admin')),
);
?>

<h1>View Accionlog #<?php echo $model->Id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id',
		'Nombre',
	),
)); ?>
