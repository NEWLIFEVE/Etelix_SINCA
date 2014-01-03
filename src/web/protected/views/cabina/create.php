<?php
/* @var $this CabinaController */
/* @var $model Cabina */

$this->breadcrumbs=array(
	'Cabinas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Listar Cabina', 'url'=>array('index')),
	array('label'=>'Administrar Cabina', 'url'=>array('admin')),
);
?>

<h1>Crear Cabina</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>