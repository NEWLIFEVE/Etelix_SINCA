<?php
/* @var $this TipousuarioController */
/* @var $model Tipousuario */

$this->breadcrumbs=array(
	'Tipousuarios'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Tipousuario', 'url'=>array('index')),
	array('label'=>'Create Tipousuario', 'url'=>array('create')),
	array('label'=>'View Tipousuario', 'url'=>array('view', 'id'=>$model->Id)),
	array('label'=>'Manage Tipousuario', 'url'=>array('admin')),
);
?>

<h1>Update Tipousuario <?php echo $model->Id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>