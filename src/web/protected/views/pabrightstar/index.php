<?php
/* @var $this PabrightstarController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pabrightstars',
);

$this->menu=array(
	array('label'=>'Create Pabrightstar', 'url'=>array('create')),
	array('label'=>'Manage Pabrightstar', 'url'=>array('admin')),
);
?>

<h1>Pabrightstars</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
