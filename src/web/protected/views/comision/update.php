<?php
/* @var $this ComisionController */
/* @var $model Comision */

$this->breadcrumbs=array(
	'Comisions'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Comision', 'url'=>array('index')),
	array('label'=>'Create Comision', 'url'=>array('create')),
	array('label'=>'View Comision', 'url'=>array('view', 'id'=>$model->Id)),
	array('label'=>'Manage Comision', 'url'=>array('admin')),
);
?>

<h1>Update Comision <?php echo $model->Id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>