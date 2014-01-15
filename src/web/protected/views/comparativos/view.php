<?php
/* @var $this ComparativosController */
/* @var $model Comparativos */

$this->breadcrumbs=array(
	'Comparativoses'=>array('index'),
	$model->Id,
);

$this->menu=array(
	array('label'=>'List Comparativos', 'url'=>array('index')),
	array('label'=>'Create Comparativos', 'url'=>array('create')),
	array('label'=>'Update Comparativos', 'url'=>array('update', 'id'=>$model->Id)),
	array('label'=>'Delete Comparativos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Comparativos', 'url'=>array('admin')),
);
?>

<h1>View Comparativos #<?php echo $model->Id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id',
		'Fecha',
		'RecargaVentasMov',
		'RecargaVentasClaro',
		'TraficoCapturaDollar',
		'CABINA_Id',
	),
)); ?>
