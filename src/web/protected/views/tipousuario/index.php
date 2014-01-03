<?php
/* @var $this TipousuarioController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tipousuarios',
);

$this->menu=array(
	array('label'=>'Create Tipousuario', 'url'=>array('create')),
	array('label'=>'Manage Tipousuario', 'url'=>array('admin')),
);
?>

<h1>Tipousuarios</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
