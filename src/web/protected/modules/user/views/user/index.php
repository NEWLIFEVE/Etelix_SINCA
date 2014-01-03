<?php
//ob_start();
//require_once($yii);
$this->breadcrumbs=array(
	UserModule::t("Users"),
);
if(UserModule::isAdmin()) {
	$this->layout='//layouts/column2';
	$this->menu=array(
	    array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin')),
	    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
	);
}
?>
<?php 

if(Yii::app()->user->isGuest){
    
    $this->redirect(Yii::app()->createAbsoluteUrl('/'));
    
}

elseif(Yii::app()->getModule('user')->user()->tipo==3 or Yii::app()->getModule('user')->user()->tipo==5){?>
<script language="javascript">
    $(document).ready(function()
    {
        $(".botonExcel").click(function(event)
        {
            $(".filters").remove();
            $(".button-column").remove();
            $("#datos_a_enviar").val( $("<div>").append( $(".items").eq(0).clone()).html());
            $("#FormularioExportacion").submit();
            $("li.selected a").click();
        });

        $(".botonCorreo").click(function(event) {
            $(".filters").remove();
            $(".button-column").remove();
            //var html = $(".enviar").clone().html()+ "<br/>" +$("table.items" ).clone().html();
            var html = "<h1>"+ $(".enviar").html() + "</h1>" + "<br/>" +$("table.items" ).html();
            $("#html").val(html);
            $("#FormularioCorreo").submit();
            $("li.selected a").click();
            alert('Correo Enviado');
        });
        
        $('.printButton').click(function(){
            $(".filters").remove();
            var printVersion =$(".grid-view" ).clone();
            $("li.selected a").click();
            // Eliminamos los elementos indeseables a trav�s de jQuery. En este caso s�lo uno.
            printVersion.children(".pager").remove();
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
<h1>
    <span class="enviar">
        Listar Usuarios
    </span> 
    <span>
        <img title="Enviar por Correo" src="<?php echo Yii::app()->request->baseUrl; ?>/images/sms-icon.png" class="botonCorreo" />
        <img title="Exportar a Excel" src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png" class="botonExcel" />
        <img title="Imprimir Tabla" src='<?php echo Yii::app()->request->baseUrl; ?>/images/info-icon.png' class='printButton' />
    </span>
</h1>
<!--<h1><?php //echo UserModule::t("List User"); ?></h1>-->
<?php
echo CHtml::beginForm(Yii::app()->createUrl('users/enviarEmail'), 'post', array('name' => 'FormularioCorreo', 'id' => 'FormularioCorreo','style'=>'display:none'));
echo CHtml::textField('html', 'Hay Efectivo', array('id' => 'html', 'style'=>'display:none')); //, array('hidden'=>'hidden')
echo CHtml::textField('vista', '', array('id' => 'vista', 'style'=>'display:none'));
echo CHtml::textField('correoUsuario',Yii::app()->getModule('user')->user()->email,array('id'=>'email','style'=>'display:none'));
echo CHtml::textField('asunto', 'Reporte Listar Usuarios Solicitado', array('id' => 'asunto', 'style'=>'display:none'));
echo CHtml::endForm();
?>
<!--<p>Enviar por Correo  </p>-->

<form action="<?php echo Yii::app()->request->baseUrl; ?>/ficheroExcel.php?nombre=Reporte_Listar_Usuarios" method="post" target="_blank" id="FormularioExportacion">

<!--<p>Exportar a Excel  </p>-->
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>
<div class="enviarTabla">
<?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'list-user-grid',
        'htmlOptions'=>array(
          'rel'=>'total',
          ),
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->username),array("user/view","id"=>$data->id))',
		),
		'create_at',
		'lastvisit_at',
	),
)); ?>
</div>
<?php }

else{
    
    $this->redirect(Yii::app()->createAbsoluteUrl('site/index'));
    
}

?>