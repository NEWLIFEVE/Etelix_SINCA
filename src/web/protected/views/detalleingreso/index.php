<?php
/* @var $this DetalleingresoController */

$this->breadcrumbs=array(
	'Detalleingreso',
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  DetallegastoController::controlAcceso($tipoUsuario);

//$this->menu=array(
//	array('label'=>'Create Detallegasto', 'url'=>array('create')),
//	array('label'=>'Manage Detallegasto', 'url'=>array('admin')),
//);
?>

<h1>Detallegastos <?php //echo "***".$this->getPageTitle()."***"; ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>