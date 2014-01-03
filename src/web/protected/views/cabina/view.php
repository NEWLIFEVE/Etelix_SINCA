<?php
/* @var $this CabinaController */
/* @var $model Cabina */

$this->breadcrumbs=array(
	'Cabinas'=>array('index'),
	$model->Id,
);


        
 $this->menu=array(
	array('label'=>'Listar Cabina', 'url'=>array('index')),
	array('label'=>'Crear Cabina', 'url'=>array('create')),
	array('label'=>'Actualizar Cabina', 'url'=>array('update', 'id'=>$model->Id)),
	array('label'=>'Eliminar Cabina', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Administrar Cabina', 'url'=>array('admin')),
);
?>

<h1>Ver Cabina #<?php echo $model->Id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id',
		'Nombre',
		'Codigo',
		'status',
	),
)); ?>
