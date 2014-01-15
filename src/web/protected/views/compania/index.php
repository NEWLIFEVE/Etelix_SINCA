<?php
/* @var $this CompaniaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Companias',
);

$this->menu=array(
	array('label'=>'Create Compania', 'url'=>array('create')),
	array('label'=>'Manage Compania', 'url'=>array('admin')),
);
?>

<h1>Companias</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
