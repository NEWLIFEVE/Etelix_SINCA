<?php
/* @var $this CabinaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cabinas',
);

$this->menu=array(
	array('label'=>'Create Cabina', 'url'=>array('create')),
	array('label'=>'Manage Cabina', 'url'=>array('admin')),
);
?>

<h1>Cabinas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
