<?php
/* @var $this BancoController */
/* @var $model Banco */

$this->breadcrumbs=array(
	'Bancos'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= BancoController::controlAcceso($tipoUsuario);
?>

<h1>Modificar Saldo Apertura de Cuenta <?php  echo $model->cUENTA->Nombre; ?></h1>

<?php echo $this->renderPartial('_form_update', array('model'=>$model)); ?>