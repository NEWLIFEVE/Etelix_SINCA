<?php
/* @var $this ComparativosController */
/* @var $model Comparativos */

$this->breadcrumbs=array(
	'Comparativoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Comparativos', 'url'=>array('index')),
	array('label'=>'Manage Comparativos', 'url'=>array('admin')),
);
?>

<h1>Create Comparativos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>