<?php
/* @var $this ParidadController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Paridads',
);

$this->menu=array(
	array('label'=>'Create Paridad', 'url'=>array('create')),
	array('label'=>'Manage Paridad', 'url'=>array('admin')),
);
?>

<h1>Paridads</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
