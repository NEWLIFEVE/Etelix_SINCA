<?php
/* @var $this BalanceController */
/* @var $model Balance */

$this->breadcrumbs=array(
	'Balances'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Balance', 'url'=>array('index')),
	array('label'=>'Create Balance', 'url'=>array('create')),
	array('label'=>'View Balance', 'url'=>array('view', 'id'=>$model->Id)),
	array('label'=>'Manage Balance', 'url'=>array('admin')),
);
?>

<h1>Actualizar Balance <?php echo $model->Id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>