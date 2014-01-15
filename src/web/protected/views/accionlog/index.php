<?php
/* @var $this AccionlogController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Accionlogs',
);

$this->menu=array(
	array('label'=>'Create Accionlog', 'url'=>array('create')),
	array('label'=>'Manage Accionlog', 'url'=>array('admin')),
);
?>

<h1>Accionlogs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
