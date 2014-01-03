<?php
/* @var $this TiponovedadController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tiponovedads',
);

$this->menu=array(
	array('label'=>'Create Tiponovedad', 'url'=>array('create')),
	array('label'=>'Manage Tiponovedad', 'url'=>array('admin')),
);
?>

<h1>Tiponovedads</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
