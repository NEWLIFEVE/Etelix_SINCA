<?php
/* @var $this LogController */
/* @var $model Log */

$this->breadcrumbs=array(
	'Logs'=>array('index'),
	$model->Id,
);

$this->menu=array(
	array('label'=>'Listar Log', 'url'=>array('index')),
	//array('label'=>'Create Log', 'url'=>array('create')),
	//array('label'=>'Update Log', 'url'=>array('update', 'id'=>$model->Id)),
	//array('label'=>'Delete Log', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Administrar Log', 'url'=>array('admin')),
);
?>

<h1>Ver Detalle de Log #<?php echo $model->Id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id',
		'Fecha',
		'Hora',
		'FechaEsp',
		//'ACCIONLOG_Id',
                'accionlog.Nombre',
		//'USERS_Id',
                'users.username',
	),
)); ?>
