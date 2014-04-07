<?php
/* @var $this CabinaController */
/* @var $model Cabina */

Yii::import('webroot.protected.controllers.BalanceController');
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=BalanceController::controlAcceso($tipoUsuario);
?>

<h1>Ver Cabina #<?php echo $model->Id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id',
		'Nombre',
		'Codigo',
                array(
                        'name'=>'status',
                        'value'=>($model->status == 1) ? 'Activo' : 'Inactivo',
                    ),
                //MUESTRA EL HORARIO DE LA CABINA
                array(
                        'type'=>'raw',
                        'name'=>'Horario',
                        'value'=>'Entrada - Salida',
                        'cssClass'=>'resaltado',
                    ),
                array(
                        'name'=>'Lunes a Sabado',
                        'value'=> Cabina::getHours($model->Id,1),
                    ),
                array(
                        'name'=>'Domingo',
                        'value'=> Cabina::getHours($model->Id,2),
                    )
	),
)); ?>
