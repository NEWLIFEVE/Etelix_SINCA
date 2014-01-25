<?php
/* @var $this NovedadController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Novedads',
);
$tipoUsuario = Yii::app()->getModule('user')->user()->tipo;
$this->menu=NovedadController::controlAcceso($tipoUsuario);
/*$this->menu=array(
	array('label'=>'Crear Novedad', 'url'=>array('create')),
	array('label'=>'Administrar Novedades', 'url'=>array('admin')),
);*/
?>
<head>
<script language="javascript">
    $(document).ready(function()
    {
        $(".botonExcel").click(function(event)
        {
            $(".filters").remove();
            $(".button-column").remove();
            for(var i = 0; i<=15;i++){
                $("#datos_a_enviar").val( $("<div>").append($(".list-view").eq(0).clone()).html());
            }
            $("#FormularioExportacion").submit();
            $("li.selected a").click();
        });

        $(".botonCorreo").click(function(event) {
            $(".filters").remove();
            $(".button-column").remove();
            //var html = $(".enviar").clone().html()+ "<br/>" +$("table.items" ).clone().html();
            var html = "<h1>"+ $(".enviar").html() + "</h1>" + "<br/>" +$(".list-view" ).html();
            $("#html").val(html);
            $("#FormularioCorreo").submit();
            $("li.selected a").click();
            alert('Correo Enviado');
        });
        
        $('.printButton').click(function(){
            $(".filters").remove();
            var printVersion =$(".list-view" ).clone();
            $("li.selected a").click();
            // Eliminamos los elementos indeseables a trav�s de jQuery. En este caso s�lo uno.
            //printVersion.children(".pager").remove();
            // Creamos el contenido del documento que se va a imprimir.
            //var printContent = $(".enviar").html()+ "<br/>" + printVersion.html(); 
            var printContent = "<h1>"+ $(".enviar").html() + "</h1>" + "<br/>" + printVersion.html();  
            // Establecemos la nueva ventana.
            var windowUrl = 'about:blank'; 
            var createdAt = new Date(); 
            var windowName = 'printScreen' + createdAt.getTime(); 
            var printWindow = window.open(windowUrl, windowName, 'resizable=0,scrollbars=0,left=500,top=000,width=868'); 
            printWindow.document.write(printContent); 
            printWindow.document.close(); 
            // Establecemos el foco.
            printWindow.focus(); 
            // Lanzamos la impresi�n.
            printWindow.print();   
        });

    });
</script>
</head>

<h1>
    <span class="enviar">
        Novedades
    </span> 
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/images/mail.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/images/print.png' class='printButton' />
    </span>
</h1>

<?php
echo CHtml::beginForm(Yii::app()->createUrl('novedad/enviarEmail'), 'post', array('name' => 'FormularioCorreo', 'id' => 'FormularioCorreo','style'=>'display:none'));
echo CHtml::textField('html', 'Hay Efectivo', array('id' => 'html', 'style'=>'display:none'));
echo CHtml::textField('vista', 'novedad/index', array('id' => 'vista', 'style'=>'display:none'));
echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
echo CHtml::textField('asunto', 'Reporte Listar Novedades Solicitado', array('id' => 'asunto', 'style'=>'display:none'));
echo CHtml::endForm();
?>
<!--<p>Enviar por Correo  </p>-->

<form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Reporte_Brightstar" method="post" target="_blank" id="FormularioExportacion">

<!--<p>Exportar a Excel  </p>-->
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
