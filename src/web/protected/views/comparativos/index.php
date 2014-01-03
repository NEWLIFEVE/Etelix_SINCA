<?php
/* @var $this ComparativosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Comparativoses',
);

$this->menu=array(
	array('label'=>'Create Comparativos', 'url'=>array('create')),
	array('label'=>'Manage Comparativos', 'url'=>array('admin')),
);
?>

<h1>Comparativoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
