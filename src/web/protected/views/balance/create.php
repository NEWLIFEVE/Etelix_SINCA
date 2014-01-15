<?php
/* @var $this BalanceController */
/* @var $model Balance */

$this->breadcrumbs=array(
	'Balances'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Listar Balance', 'url'=>array('index')),
	array('label'=>'Administrar Balance', 'url'=>array('admin')),
        array('label'=>'Declarar Apertura', 'url'=>array('createApertura')),
	array('label'=>'Declarar Llamadas', 'url'=>array('createLlamadas')),
	array('label'=>'Declarar Deposito', 'url'=>array('createDeposito')),
);
?>

<h1>Create Balance</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>