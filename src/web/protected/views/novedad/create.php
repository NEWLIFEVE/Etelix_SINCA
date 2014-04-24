<?php
/* @var $this NovedadController */
/* @var $model Novedad */

$this->breadcrumbs=array(
	'Novedads'=>array('index'),
	'Create',
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=NovedadController::controlAcceso($tipoUsuario);

//$this->menu=array(
//	array('label'=>'List Novedad', 'url'=>array('index')),
//	array('label'=>'Manage Novedad', 'url'=>array('admin')),
//);
?>

<h1>
    <span class="enviar">
        Reportar Falla
    </span>
</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>