<?php
/* @var $this BancoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Bancos',
);

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= BancoController::controlAcceso($tipoUsuario);
//$this->menu=array(
//	array('label'=>'List Banco', 'url'=>array('index')),
//	array('label'=>'Create Banco', 'url'=>array('create')),
//);
?>

<h1>Bancos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
