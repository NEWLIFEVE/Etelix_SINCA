<?php
/* @var $this BancoController */
/* @var $model Banco */

$this->breadcrumbs=array(
	'Bancos'=>array('index'),
	'Create',
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= BancoController::controlAcceso($tipoUsuario);
?>

<h1>DECLARAR SALDO DE APERTURA BANCO </h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>