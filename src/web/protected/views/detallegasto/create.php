<?php
/* @var $this DetallegastoController */
/* @var $model Detallegasto */

$this->breadcrumbs=array(
	'Detallegastos'=>array('index'),
	'Create',
);
?>

<script>
    
    $(document).ready(function(){
        selectGasto();
        
        $("#Detallegasto_TIPOGASTO_Id").click(function(){
            if($("#Detallegasto_TIPOGASTO_Id option:selected").html()=="Seleccione uno"){
                $("#DetalleGasto").slideUp("slow");
                $("#DetalleGasto input").val("");
                $("#DetalleGasto textarea").val("");
            }
            else if($("#Detallegasto_TIPOGASTO_Id option:selected").html()=="Nuevo.."){
                $("#DetalleGasto").slideDown("slow");
                $("#GastoMesAnterior").slideUp("slow");
                $("tr#Gasto").css("display","inline");
                $("#GastoNuevo").slideDown("slow");
                
                $("#DetalleGasto input").val("");
                $("#DetalleGasto textarea").val("");
            }
            else if($("#Detallegasto_TIPOGASTO_Id option:selected").html()!="Nuevo.."){
                $("#DetalleGasto").slideDown("slow");
                $("#GastoMesAnterior").slideUp("slow");
                
                $("#GastoNuevo").slideUp("slow");
                $("tr#Gasto").slideUp("slow");
                $("#DetalleGasto input").val("");
                $("#DetalleGasto textarea").val("");
            }
            else if($("#Detallegasto_TIPOGASTO_Id option:selected").html()!="Seleccionar Categoria"){
                $("#DetalleGasto").slideDown("slow");
                $("#GastoMesAnterior").slideDown("slow");
                $("#GastoNuevo").slideUp("slow");
                $("#DetalleGasto input").val("");
                $("#DetalleGasto textarea").val("");
            }
        });
    });
    
</script>

<?php
//$this->menu=array(
//	array('label'=>'List Detallegasto', 'url'=>array('index')),
//	array('label'=>'Manage Detallegasto', 'url'=>array('admin')),
//);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=  DetallegastoController::controlAcceso($tipoUsuario);

?>

<h1>Declarar Gasto</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'model_cabina'=>$model_cabina)); ?>