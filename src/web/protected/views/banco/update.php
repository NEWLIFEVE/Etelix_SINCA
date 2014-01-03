<?php
/* @var $this BancoController */
/* @var $model Banco */

$this->breadcrumbs=array(
	'Bancos'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Banco', 'url'=>array('index')),
	array('label'=>'Create Banco', 'url'=>array('create')),
	array('label'=>'View Banco', 'url'=>array('view', 'id'=>$model->Id)),
	array('label'=>'Manage Banco', 'url'=>array('admin')),
);
?>

<h1>Update Banco <?php echo $model->Id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>