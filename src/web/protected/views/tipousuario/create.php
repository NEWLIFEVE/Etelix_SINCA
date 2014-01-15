<?php
/* @var $this TipousuarioController */
/* @var $model Tipousuario */

$this->breadcrumbs=array(
	'Tipousuarios'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Tipousuario', 'url'=>array('index')),
	array('label'=>'Manage Tipousuario', 'url'=>array('admin')),
);
?>

<h1>Create Tipousuario</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>