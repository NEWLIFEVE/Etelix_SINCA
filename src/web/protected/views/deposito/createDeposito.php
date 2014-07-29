<?php
/* @var $this BalanceController */
/* @var $model Balance */

$this->breadcrumbs=array(
	'Depositos'=>array('index'),
	'Create',
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu =  DepositoController::controlAcceso($tipoUsuario);
//$this->menu=array(
//	array('label'=>'Listar Balance', 'url'=>array('index')),
//	array('label'=>'Administrar Balance', 'url'=>array('admin')),
//        array('label'=>'Declarar Apertura', 'url'=>array('createApertura')),
//	array('label'=>'Declarar Llamadas', 'url'=>array('createLlamadas')),
//    
//);
?>

<h1>Declarar Deposito</h1>


<?php 
//$horario = Utility::hora(15,true);
//if($horario)
//{
//	echo "Lo sentimos, solo puede declarar depositos hasta las 3:00pm.";
//}
//else
//{
	echo "<h5 style='color:red;'>Adevertencia: 'Cada deposito que declare debe corresponder al balance de un solo dia laboral'.</h5>";
	echo $this->renderPartial('_form_deposito', array('model'=>$model));
//}

?>