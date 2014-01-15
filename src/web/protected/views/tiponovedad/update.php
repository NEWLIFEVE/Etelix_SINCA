<?php
/* @var $this TiponovedadController */
/* @var $model Tiponovedad */

$this->breadcrumbs=array(
	'Tiponovedads'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Tiponovedad', 'url'=>array('index')),
	array('label'=>'Create Tiponovedad', 'url'=>array('create')),
	array('label'=>'View Tiponovedad', 'url'=>array('view', 'id'=>$model->Id)),
	array('label'=>'Manage Tiponovedad', 'url'=>array('admin')),
);
?>

<h1>Update Tiponovedad <?php echo $model->Id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>