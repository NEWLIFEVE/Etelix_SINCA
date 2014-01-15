<?php
/* @var $this ParidadController */
/* @var $model Paridad */

$this->breadcrumbs=array(
	'Paridads'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Paridad', 'url'=>array('index')),
	array('label'=>'Create Paridad', 'url'=>array('create')),
	array('label'=>'View Paridad', 'url'=>array('view', 'id'=>$model->Id)),
	array('label'=>'Manage Paridad', 'url'=>array('admin')),
);
?>

<h1>Update Paridad <?php echo $model->Id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>