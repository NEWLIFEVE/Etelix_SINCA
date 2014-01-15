<?php
/* @var $this AccionlogController */
/* @var $model Accionlog */

$this->breadcrumbs=array(
	'Accionlogs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Accionlog', 'url'=>array('index')),
	array('label'=>'Manage Accionlog', 'url'=>array('admin')),
);
?>

<h1>Create Accionlog</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>