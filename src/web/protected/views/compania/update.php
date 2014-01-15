<?php
/* @var $this CompaniaController */
/* @var $model Compania */

$this->breadcrumbs=array(
	'Companias'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Compania', 'url'=>array('index')),
	array('label'=>'Create Compania', 'url'=>array('create')),
	array('label'=>'View Compania', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Compania', 'url'=>array('admin')),
);
?>

<h1>Update Compania <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>