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
//	array('label'=>'Declarar Llamadas', 'url'=>array('createLlamadas')),
//	array('label'=>'Declarar Deposito', 'url'=>array('createDeposito')),
//);
?>

<h1>Declarar Saldo de Cierre</h1>

<?php
$max = Utility::hora(23,false);
$min = Utility::hora(7,true);
if($min && $max)
{
	echo $this->renderPartial('_form_cierre', array('model'=>$model));
}
else
{
	echo "Lo sentimos, despues de las 12:00am no puede declarar el saldo de cierre";
}
  ?>