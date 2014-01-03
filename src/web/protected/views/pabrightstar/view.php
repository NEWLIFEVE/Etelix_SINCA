<?php
/* @var $this PabrightstarController */
/* @var $model Pabrightstar */

$this->breadcrumbs=array(
	'Pabrightstars'=>array('index'),
	$model->Id,
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= PabrightstarController::controlAcceso($tipoUsuario);
//
//$this->menu=array(
//	array('label'=>'List Pabrightstar', 'url'=>array('index')),
//	array('label'=>'Create Pabrightstar', 'url'=>array('create')),
//	array('label'=>'Update Pabrightstar', 'url'=>array('update', 'id'=>$model->Id)),
//	array('label'=>'Delete Pabrightstar', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Pabrightstar', 'url'=>array('admin')),
//);
?>

<h1>View Pabrightstar #<?php echo $model->Id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id',
		'Fecha',
//		'Compania',
            array(
                'name'=>'Compania',
                'value'=>$model->compania->nombre,
                ),
		'SaldoAperturaPA',
		'TransferenciaPA',
		'ComisionPA',
		'SaldoCierrePA',
	),
)); ?>
