<?php
/* @var $this ComisionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Comisions',
);

$this->menu=array(
	array('label'=>'Create Comision', 'url'=>array('create')),
	array('label'=>'Manage Comision', 'url'=>array('admin')),
);
?>

<h1>Comisions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
