<?php
/* @var $this ComparativosController */
/* @var $model Comparativos */

$this->breadcrumbs=array(
	'Comparativoses'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Comparativos', 'url'=>array('index')),
	array('label'=>'Create Comparativos', 'url'=>array('create')),
	array('label'=>'View Comparativos', 'url'=>array('view', 'id'=>$model->Id)),
	array('label'=>'Manage Comparativos', 'url'=>array('admin')),
);
?>

<h1>Update Comparativos <?php echo $model->Id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>