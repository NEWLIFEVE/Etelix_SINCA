<?php
/* @var $this BalanceController */
/* @var $model Balance */

$this->breadcrumbs=array(
	'Balances'=>array('index'),
	'Create',
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=BalanceController::controlAcceso($tipoUsuario);
//$this->menu=array(
//	array('label'=>'Listar Balance', 'url'=>array('index')),
//	array('label'=>'Administrar Balance', 'url'=>array('admin')),
//        array('label'=>'Declarar Apertura', 'url'=>array('createApertura')),
//	array('label'=>'Declarar Deposito', 'url'=>array('createDeposito')),
//);
?>

<h1>Declarar Ventas</h1>

<?php
//$horario = Utility::hora(12,true);
//if($horario)
//{
//	echo "Lo sentimos, solo puede declarar ventas las 12:00pm.";
//}
//else
//{
	echo $this->renderPartial('_form_services', array('model'=>$model));
//}  
?>