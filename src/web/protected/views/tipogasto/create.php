<?php
/* @var $this TipogastoController */
/* @var $model Tipogasto */

$this->breadcrumbs=array(
	'Tipogastos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Tipogasto', 'url'=>array('index')),
	array('label'=>'Manage Tipogasto', 'url'=>array('admin')),
);
?>

<h1>Create Tipogasto</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>