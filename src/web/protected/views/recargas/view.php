<?php
/* @var $this RecargasController */
/* @var $model Recargas */

$this->breadcrumbs=array(
	'Recargases'=>array('index'),
	$model->id,
);
Yii::import('webroot.protected.controllers.PabrightstarController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu= PabrightstarController::controlAcceso($tipoUsuario);
//$this->menu=array(
//	array('label'=>'List Recargas', 'url'=>array('index')),
//	array('label'=>'Create Recargas', 'url'=>array('create')),
//	array('label'=>'Update Recargas', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Recargas', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Recargas', 'url'=>array('admin')),
//);
?>

<h1>Detalle Recarga #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'FechaHora',
		'MontoRecarga',
               array(
                'name'=>'Cabina',
                'value'=>Cabina::getNombreCabina2($model->bALANCE->CABINA_Id),
                ),
               array(
                'name'=>'Compania',
                'value'=>Compania::getNombreCompania($model->pABRIGHTSTAR->Compania),
                ),
                
                //Compania::getNombreCompania($model->pABRIGHTSTAR->compania)
		//'BALANCE_Id',
		//'PABRIGHTSTAR_Id',
	),
)); ?>
