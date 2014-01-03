<?php
/* @var $this RecargasController */
/* @var $model Recargas */

$this->breadcrumbs=array(
	'Recargases'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Recargas', 'url'=>array('index')),
	array('label'=>'Create Recargas', 'url'=>array('create')),
	array('label'=>'View Recargas', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Recargas', 'url'=>array('admin')),
);
?>

<h1>Update Recargas <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>