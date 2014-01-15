<?php
/* @var $this LogController */
/* @var $model Log */

$this->breadcrumbs=array(
	'Logs'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Log', 'url'=>array('index')),
	//array('label'=>'Create Log', 'url'=>array('create')),
	array('label'=>'View Log', 'url'=>array('view', 'id'=>$model->Id)),
	array('label'=>'Manage Log', 'url'=>array('admin')),
);
?>

<h1>Update Log <?php echo $model->Id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>