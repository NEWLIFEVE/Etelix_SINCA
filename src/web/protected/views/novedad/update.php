<?php
/* @var $this NovedadController */
/* @var $model Novedad */

$this->breadcrumbs=array(
	'Novedads'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=NovedadController::controlAcceso($tipoUsuario);
/*$this->menu=array(
	array('label'=>'List Novedad', 'url'=>array('index')),
	array('label'=>'Create Novedad', 'url'=>array('create')),
	array('label'=>'View Novedad', 'url'=>array('view', 'id'=>$model->Id)),
	array('label'=>'Manage Novedad', 'url'=>array('admin')),
);*/
?>
<head>
    
    <script>
    
    $(document).ready(function() {
        
        $("label").css('display','inline');
        
    });
    
    </script>
    
</head>
<h1>Editar Novedad <?php echo $model->Id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>