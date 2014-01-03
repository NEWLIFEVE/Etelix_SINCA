<?php
/* @var $this AccionlogController */
/* @var $model Accionlog */

$this->breadcrumbs=array(
	'Accionlogs'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Accionlog', 'url'=>array('index')),
	array('label'=>'Create Accionlog', 'url'=>array('create')),
	array('label'=>'View Accionlog', 'url'=>array('view', 'id'=>$model->Id)),
	array('label'=>'Manage Accionlog', 'url'=>array('admin')),
);
?>

<h1>Update Accionlog <?php echo $model->Id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>