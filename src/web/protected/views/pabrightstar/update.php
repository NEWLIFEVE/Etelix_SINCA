<?php
/* @var $this PabrightstarController */
/* @var $model Pabrightstar */

$this->breadcrumbs=array(
	'Pabrightstars'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Pabrightstar', 'url'=>array('index')),
	array('label'=>'Create Pabrightstar', 'url'=>array('create')),
	array('label'=>'View Pabrightstar', 'url'=>array('view', 'id'=>$model->Id)),
	array('label'=>'Manage Pabrightstar', 'url'=>array('admin')),
);
?>

<h1>Update Pabrightstar <?php echo $model->Id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>