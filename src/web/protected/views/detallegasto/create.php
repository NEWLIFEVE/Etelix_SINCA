<?php
/* @var $this DetallegastoController */
/* @var $model Detallegasto */

$this->breadcrumbs=array(
	'Detallegastos'=>array('index'),
	'Create',
);
?>



<?php
//$this->menu=array(
//	array('label'=>'List Detallegasto', 'url'=>array('index')),
//	array('label'=>'Manage Detallegasto', 'url'=>array('admin')),
//);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  DetallegastoController::controlAcceso($tipoUsuario);

?>

<h1>Declarar Gasto</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'model_cabina'=>$model_cabina,'model_category'=>$model_category)); ?>