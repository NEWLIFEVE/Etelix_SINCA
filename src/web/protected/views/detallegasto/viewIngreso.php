<?php
/* @var $this DetallegastoController */
/* @var $model Detallegasto */

$this->breadcrumbs=array(
	'Detalleingreso'=>array('index'),
	$model->Id,
);

$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  DetallegastoController::controlAcceso($tipoUsuario);

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
                    'name'=>'TIPOINGRESO_Id',
                    'value'=>$model->tIPOINGRESO->Nombre,
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
                   array(
                    'name'=>'FechaMes',
                    'value'=>Utility::monthName($model->FechaMes),
                ),
		'Descripcion',
               
             
               
	),
)); ?>
