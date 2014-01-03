<?php
/* @var $this TipogastoController */
/* @var $model Tipogasto */

$this->breadcrumbs=array(
	'Tipogastos'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Tipogasto', 'url'=>array('index')),
	array('label'=>'Create Tipogasto', 'url'=>array('create')),
	array('label'=>'View Tipogasto', 'url'=>array('view', 'id'=>$model->Id)),
	array('label'=>'Manage Tipogasto', 'url'=>array('admin')),
);
?>

<h1>Update Tipogasto <?php echo $model->Id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>