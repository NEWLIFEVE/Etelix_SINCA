<?php
/* @var $this CabinaController */
/* @var $model Cabina */

$this->breadcrumbs=array(
	'Cabinas'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cabina', 'url'=>array('index')),
	array('label'=>'Create Cabina', 'url'=>array('create')),
	array('label'=>'View Cabina', 'url'=>array('view', 'id'=>$model->Id)),
	array('label'=>'Manage Cabina', 'url'=>array('admin')),
);
?>

<!--<h1>Update Cabina <?php // echo $model->Id; ?></h1>-->
<h1>
  <span class="enviar" style="position: relative; top: -7px;">
    <?php echo 'Actualizar Horario - '.$model->Nombre; ?> 
  </span >
</h1>

<?php echo $this->renderPartial('_formHours', array('model'=>$model)); ?>