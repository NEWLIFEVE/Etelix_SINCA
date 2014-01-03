<?php
/* @var $this TipogastoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tipogastos',
);

$this->menu=array(
	array('label'=>'Create Tipogasto', 'url'=>array('create')),
	array('label'=>'Manage Tipogasto', 'url'=>array('admin')),
);
?>

<h1>Tipogastos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
