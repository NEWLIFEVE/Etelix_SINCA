<?php
/* @var $this TiponovedadController */
/* @var $model Tiponovedad */

$this->breadcrumbs=array(
	'Tiponovedads'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Tiponovedad', 'url'=>array('index')),
	array('label'=>'Manage Tiponovedad', 'url'=>array('admin')),
);
?>

<h1>Create Tiponovedad</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>