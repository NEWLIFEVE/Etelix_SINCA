<?php
/* @var $this DetallegastoController */
/* @var $model Detallegasto */

$this->breadcrumbs=array(
	'Detallegastos'=>array('index'),
	$model->Id,
);

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  DetallegastoController::controlAcceso($tipoUsuario);

//$this->menu=array(
//	array('label'=>'List Detallegasto', 'url'=>array('index')),
//	array('label'=>'Create Detallegasto', 'url'=>array('create')),
//	array('label'=>'Update Detallegasto', 'url'=>array('update', 'id'=>$model->Id)),
//	array('label'=>'Delete Detallegasto', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Detallegasto', 'url'=>array('admin')),
//);
?>

<h1>Detalle del Gasto #<?php echo $model->Id;?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id',
            array(
                    'name'=>'CABINA_Id',
                    'value'=>$model->cABINA->Nombre,
                ),
             array(
                    'name'=>'USERS_Id',
                    'value'=>$model->uSERS->username,
                ),
             array(
                    'name'=>'TIPOGASTO_Id',
                    'value'=>$model->tIPOGASTO->Nombre,
                ),
		'Monto',
                 array(
                    'name'=>'moneda',
                    'value'=>  Detallegasto::monedaGasto($model->moneda),
                ),
                 array(
                    'name'=>'CUENTA_Id',
                    'value'=> Cuenta::validateCuentaNombre($model->CUENTA_Id),
                ),
                'beneficiario',
                   array(
                    'name'=>'FechaMes',
                    'value'=>Utility::monthName($model->FechaMes),
                ),
		'FechaVenc',
		'Descripcion',
		array(
                    'name'=>'status',
                    'value'=>Detallegasto::estadoGasto($model->status),
                ),
               
             
               
	),
)); ?>
