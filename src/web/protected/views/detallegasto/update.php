<?php
/* @var $this DetallegastoController */
/* @var $model Detallegasto */

$this->breadcrumbs=array(
	'Detallegastos'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);?>

<script>
    
    $(document).ready(function(){
        $("#ocultarEnUpdate").addClass("ocultar");
        $("#Detallegasto_category").attr('disabled','disabled');
        $("#Detallegasto_TIPOGASTO_Id").attr('disabled','disabled');
        $("#DetalleGasto").slideDown("slow");
        $("#Detallegasto_TIPOGASTO_Id").click(function(){
            if($("#Detallegasto_TIPOGASTO_Id option:selected").html()=="Seleccione uno"){
                $("#DetalleGasto").slideUp("slow");
            }
            else if($("#Detallegasto_TIPOGASTO_Id option:selected").html()=="Nuevo.."){
                $("#DetalleGasto").slideDown("slow");
                $("#GastoNuevo").slideDown("slow");
            }
            else{
                $("#DetalleGasto").slideDown("slow");
                $("#GastoNuevo").slideUp("slow");
            }
        });
    });
    
</script>

<?php
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  DetallegastoController::controlAcceso($tipoUsuario);

?>

<h1>Actualizar Gasto <?php echo $model->Id;?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'model_cabina'=>$model_cabina)); ?>