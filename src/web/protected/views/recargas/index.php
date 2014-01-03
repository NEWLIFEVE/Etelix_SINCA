<?php
/* @var $this RecargasController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Recargases',
);

$this->menu=array(
	array('label'=>'Create Recargas', 'url'=>array('create')),
	array('label'=>'Manage Recargas', 'url'=>array('admin')),
);
?>

<h1>Recargases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
